<?php
Yii::import("packages.rbac.models.*");
Yii::import("packages.stateMachine.*");
/**
 * The user model.
 * @author Charles Pick
 * @package packages.users.models
 * @property integer $id The id of the user
 * @property string $name The name of the user
 * @property string $salt The salt to use when hashing the password
 * @property string $password The password, this will be hashed
 * @property string $email The user's email address
 * @property string $status The user's status, either pending, active or deactivated
 * @property string $registeredAt The date / time the user registered
 * @property boolean $requiresNewPassword Whether a new password is required for this user
 *
 * @property AAuthRole[] $roles the authorisation roles that this user belongs to
 * @property AUserGroup[] $groups The groups this user belongs to
 * @property integer $totalGroups The total number of groups this user belongs to
 * @property AUserPreference[] $preferences The user's preferences
 *
 * @property AStateMachine $AStateMachine the state machine that keeps track of the user's status
 */
abstract class AUser extends CActiveRecord {

	const STATE_PENDING = "pending";
	const STATE_ACTIVE = "active";
	const STATE_DEACTIVATED = "deactivated";
	/**
	 * The user's activation status
	 * @var string
	 */
	public $status = self::STATE_PENDING;
	/**
	 * The keyword to use when searching for users
	 * @var string
	 */
	public $searchKeyword;

	/**
	 * The total number of unread messages for this user
	 * @var integer
	 */
	protected $_totalUnreadMessages;
	/**
	 * The total number of unread conversations for this user
	 * @var integer
	 */
	protected $_totalUnreadConversations;

	/**
	 * Holds a list of items in the activity log for this user
	 * @var ALogItem[]
	 */
	protected $_activityLog;

	/**
	 * The behaviors associated with the user model.
	 * @see CActiveRecord::behaviors()
	 */
	public function behaviors() {
		$behaviors = array(
			"AStateMachine" => array(
				"class" => "packages.stateMachine.AStateMachine",
				"defaultStateName" => self::STATE_PENDING,
				"states" => array(
					array(
						"class" => "packages.users.models.states.APendingUserState",
						"name" => self::STATE_PENDING
					),
					array(
						"class" => "packages.users.models.states.AActiveUserState",
						"name" => self::STATE_ACTIVE
					),
					array(
						"class" => "packages.users.models.states.ADeactivatedUserState",
						"name" => self::STATE_DEACTIVATED
					),
				),
				"stateName" => $this->status,
			),
		);
		if (Yii::app()->getModule("users")->enableProfileImages) {
			$behaviors['AResourceful'] = array(
				"class" => "packages.resources.components.AResourceful",
				"attributes" => array(
					"thumbnail" => array(
						"fileTypes" => array("png", "jpg"),
					)
				)
			);
		}
		return $behaviors;
	}

	/**
	 * The default validation rules.
	 * Child classes that specify more rules should merge with
	 * the parent implementation, e.g.
	 * <pre>
	 * public function rules() {
	 * 	return CMap::mergeArray(parent::rules(),array(
	 * 		// custom rules go here...
	 * ));
	 * }
	 * </pre>
	 * @return array the validation rules
	 */
	public function rules() {
		return array(
			array("name,email,password","required","on" => "register"),
			array("name,email","required","on" => "update"),
			array("email","email"),
			array("email", "unique"),
			array("requiresNewPassword","boolean", "on" => "admin"),
			array("name,email,password","safe", "on" => "admin"),
			array("password","length","min" => 6),
			array("email","required", "on" => "resetPassword"),
			array("password","required", "on" => "newPassword"),

			array("searchKeyword", "safe", "on" => "search"),
		);
	}

	/**
	 * Gets the relation configuration for this model
	 * @return array the relation configuration for this model
	 */
	public function relations() {
		$module = Yii::app()->getModule("users");
		$memberClassName = $module->userGroupMemberModelClass;
		$tableName = $memberClassName::model()->tableName();
		return array(
			"roles" => array(self::MANY_MANY,"AAuthRole","AuthAssignment(userid,itemname)"),
			"groups" => array(self::MANY_MANY,$module->userGroupModelClass,$tableName."(userId,groupId)"),
			"totalGroups" => array(self::STAT,$module->userGroupModelClass,$tableName."(userId,groupId)"),
			"preferences" => array(self::HAS_MANY,"AUserPreference","userId"),
		);
	}
	/**
	 * Gets a user's preference for the given site preference name.
	 * If the user hasn't specified a preference for the given setting, the default will be returned
	 * @param string $name the name of the preference
	 * @return mixed the vlaue of the preference.
	 */
	public function getPreference($name) {
		foreach($this->preferences as $preference) {
			if ($preference->name == $name) {
				return $preference->value;
			}
		}
		return Yii::app()->preferenceManager->getPreferences()->itemAt($name)->defaultValue;
	}

	/**
	 * Sets a user's preference for a certain setting
	 * @param string $name the name of the preference to set
	 * @param mixed $value the value of the preference
	 * @return boolean whether the preference was saved or not
	 */
	public function setPreference($name, $value) {
		foreach($this->preferences as $preference) {
			if ($preference->name == $name) {
				$preference->value = $value;
				return $preference->save();
			}
		}
		$preference = new AUserPreference();
		$preference->name = $name;
		$preference->userId = $this->id;
		$preference->value = $value;
		return $preference->save();
	}



	/**
	 * Generates an activation code for this user
	 * @return string the activation code for this user
	 */
	public function getActivationCode() {
		return sha1("Activate:".$this->id.$this->salt.".".$this->password);
	}

	/**
	 * Invoked after a user model is saved.
	 * Invokes beforeRegister()
	 * @see CActiveRecord::beforeSave()
	 * @see beforeRegister()
	 * @return boolean whether the save should continue or not
	 */
	protected function beforeSave() {
		if ($this->scenario == "register" && !$this->beforeRegister()) {
			return false;
		}
		return parent::beforeSave();
	}

	/**
	 * This method is invoked after a user is saved
	 * The default implementation raises the {@link onAfterRegister} and {@link onAfterSave} events.
	 * @see CActiveRecord::afterSave()
	 */
	protected function afterSave() {
		if ($this->scenario == "register") {
			$this->afterRegister();
		}
		parent::afterSave();
	}

	/**
	 * This method is invoked before a user registers with the site
	 * The default implementation raises the {@link onBeforeRegister} event.
	 * You may override this method to do any preparation work for user registration.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the user should be allowed to register. Defaults to true.
	 */
	protected function beforeRegister() {
		if($this->hasEventHandler('onBeforeRegister'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeRegister($event);
			return $event->isValid;
		}
		else
			return true;
	}

	/**
	 * This event is raised before a user registers.
	 * By setting {@link CModelEvent::isValid} to be false, the normal {@link save()} process will be stopped.
	 * @param CModelEvent $event the event parameter
	 */
	public function onBeforeRegister($event) {
		$this->raiseEvent('onBeforeRegister',$event);
	}

	/**
	 * This method is invoked after a user registers successfully
	 * The default implementation raises the {@link onAfterRegister} event.
	 * You may override this method to do postprocessing after registration.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterRegister() {
		Yii::log("[$this->id] User registered: $this->name ($this->email)","register","user.activity");
		if($this->hasEventHandler('onAfterRegister'))
			$this->onAfterRegister(new CEvent($this));
	}

	/**
	 * This event is raised after the user registers
	 * @param CEvent $event the event parameter
	 */
	public function onAfterRegister($event)	{
		$this->raiseEvent('onAfterRegister',$event);
	}

	/**
	 * Activates the user's account.
	 * @param boolean $runValidation whether to run validation or not, defaults to true
	 * @return boolean whether the account was activated or not
	 */
	public function activate($runValidation = true) {
		if (!$this->beforeActivate()) {
			return false;
		}
		$status = $this->status;
		$this->status = self::STATE_ACTIVE;
		if (!$this->transition(self::STATE_ACTIVE) || !$this->save($runValidation)) {
			$this->status = $status;
			return false;
		}
		$this->afterActivate();
		return true;
	}

	/**
	 * This method is invoked before a user activates their account
	 * The default implementation raises the {@link onBeforeActivate} event.
	 * You may override this method to do any preparation work for account activation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the account can be activated. Defaults to true.
	 */
	protected function beforeActivate() {
		if($this->hasEventHandler('onBeforeActivate'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeActivate($event);
			return $event->isValid;
		}
		else
			return true;
	}

	/**
	 * This event is raised before a user account is activated.
	 * By setting {@link CModelEvent::isValid} to be false, the normal {@link activate()} process will be stopped.
	 * @param CModelEvent $event the event parameter
	 */
	public function onBeforeActivate($event) {
		$this->raiseEvent('onBeforeActivate',$event);
	}

	/**
	 * This method is invoked after a user account is activated
	 * The default implementation raises the {@link onAfterActivate} event.
	 * You may override this method to do postprocessing after account activation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterActivate() {
		Yii::log("[$this->id] User account activated: $this->name","activate","user.activity");
		if($this->hasEventHandler('onAfterActivate'))
			$this->onAfterActivate(new CEvent($this));
	}

	/**
	 * This event is raised after the user account is activated
	 * @param CEvent $event the event parameter
	 */
	public function onAfterActivate($event)	{
		$this->raiseEvent('onAfterActivate',$event);
	}


	/**
	 * Deactivates the user's account.
	 * @param boolean $runValidation whether to run validation or not, defaults to true
	 * @return boolean whether the account was deactivated or not
	 */
	public function deactivate($runValidation = true) {
		if (!$this->beforeDeactivate()) {
			return false;
		}
		$status = $this->status;
		$this->status = self::STATE_DEACTIVATED;
		if (!$this->transition(self::STATE_DEACTIVATED) || !$this->save($runValidation)) {
			$this->status = $status;
			return false;
		}
		$this->afterDeactivate();
		return true;
	}

	/**
	 * This method is invoked before a user's account is deactivated
	 * The default implementation raises the {@link onBeforeDeactivate} event.
	 * You may override this method to do any preparation work for account deactivation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the account can be deactivated. Defaults to true.
	 */
	protected function beforeDeactivate() {
		if($this->hasEventHandler('onBeforeDeactivate'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeDeactivate($event);
			return $event->isValid;
		}
		else
			return true;
	}

	/**
	 * This event is raised before a user account is deactivated.
	 * By setting {@link CModelEvent::isValid} to be false, the normal {@link deactivate()} process will be stopped.
	 * @param CModelEvent $event the event parameter
	 */
	public function onBeforeDeactivate($event) {
		$this->raiseEvent('onBeforeDeactivate',$event);
	}

	/**
	 * This method is invoked after a user account is deactivated
	 * The default implementation raises the {@link onAfterDeactivate} event.
	 * You may override this method to do postprocessing after account activation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterDeactivate() {
		Yii::log("[$this->id] User account deactivated: $this->name","deactivate","user.activity");
		if($this->hasEventHandler('onAfterDeactivate'))
			$this->onAfterDeactivate(new CEvent($this));
	}

	/**
	 * This event is raised after the user account is deactivated
	 * @param CEvent $event the event parameter
	 */
	public function onAfterDeactivate($event)	{
		$this->raiseEvent('onAfterDeactivate',$event);
	}

	/**
	 * Reactivates the user's account.
	 * @param boolean $runValidation whether to run validation or not, defaults to true
	 * @return boolean whether the account was reactivated or not
	 */
	public function reactivate($runValidation = true) {
		if (!$this->beforeReactivate()) {
			return false;
		}
		$status = $this->status;
		$this->status = self::STATE_ACTIVE;
		if (!$this->transition(self::STATE_ACTIVE) || !$this->save($runValidation)) {
			$this->status = $status;
			return false;
		}
		$this->afterReactivate();
		return true;
	}

	/**
	 * This method is invoked before a user reactivates their account
	 * The default implementation raises the {@link onBeforeReactivate} event.
	 * You may override this method to do any preparation work for account activation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the account can be reactivated. Defaults to true.
	 */
	protected function beforeReactivate() {
		if($this->hasEventHandler('onBeforeReactivate'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeReactivate($event);
			return $event->isValid;
		}
		else
			return true;
	}

	/**
	 * This event is raised before a user account is reactivated.
	 * By setting {@link CModelEvent::isValid} to be false, the normal {@link reactivate()} process will be stopped.
	 * @param CModelEvent $event the event parameter
	 */
	public function onBeforeReactivate($event) {
		$this->raiseEvent('onBeforeReactivate',$event);
	}

	/**
	 * This method is invoked after a user account is reactivated
	 * The default implementation raises the {@link onAfterReactivate} event.
	 * You may override this method to do postprocessing after account activation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterReactivate() {
		Yii::log("[$this->id] User account reactivated: $this->name","reactivate","user.activity");
		if($this->hasEventHandler('onAfterReactivate'))
			$this->onAfterReactivate(new CEvent($this));
	}

	/**
	 * This event is raised after the user account is reactivated
	 * @param CEvent $event the event parameter
	 */
	public function onAfterReactivate($event)	{
		$this->raiseEvent('onAfterReactivate',$event);
	}
	/**
	 * Returns the user's name.
	 * @return string the user's name
	 */
	public function __toString() {
		return $this->name;
	}

	/**
	 * Gets the total number of unread conversations for this user
	 * @return integer the total number of unread conversations
	 */
	public function getTotalUnreadConversations()
	{
		if ($this->_totalUnreadConversations === null) {
			$this->getTotalUnreadMessages();
		}
		return $this->_totalUnreadConversations;
	}

	/**
	 * Gets the total number of unread messages for this user
	 * @return integer the total number of unread messages
	 */
	public function getTotalUnreadMessages()
	{
		if ($this->_totalUnreadMessages === null) {
			$sql = "SELECT
						COUNT(messages.id), COUNT(DISTINCT messages.conversationId)
					FROM messagerecipients
					INNER JOIN messages
						ON messages.id = messagerecipients.messageId
					WHERE messagerecipients.userId = :userId
					";
			$command = $this->getDbConnection()->createCommand($sql);
			$command->bindValue(":userId",$this->id);
			list($this->_totalUnreadMessages, $this->_totalUnreadConversations) = array_values($command->queryRow());
		}
		return $this->_totalUnreadMessages;
	}
	/**
	 * Logs activity for this user
	 * @param integer $type the type of the activity
	 * @param string $message a helpful message that describes this activity
	 * @param null $data
	 */
	public function log($type, $message, $data = null) {

	}

	/**
	 * Named Scope: Retrieve only active users
	 * @return AUser the current object with the scope applied
	 */
	public function active() {
		$criteria = new CDbCriteria();
		$criteria->condition = "status = :userStatus";
		$criteria->params[":userStatus"] = self::STATE_ACTIVE;
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;
	}

	/**
	 * Named Scope: Retrieve only users that have not activated their account
	 * @return AUser the current object with the scope applied
	 */
	public function pending() {
		$criteria = new CDbCriteria();
		$criteria->condition = "status = :userStatus";
		$criteria->params[":userStatus"] = self::STATE_PENDING;
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;
	}

	/**
	 * Named Scope: Retrieve only deactivated users
	 * @return AUser the current object with the scope applied
	 */
	public function deactivated() {
		$criteria = new CDbCriteria();
		$criteria->condition = "status = :userStatus";
		$criteria->params[":userStatus"] = self::STATE_DEACTIVATED;
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;
	}

	public function withMessageCounts() {
		$criteria = new CDbCriteria();
		$alias = $this->getTableAlias();
		$criteria->select = array(
			"t.*",
			"COUNT(messages.id) AS _totalUnreadMessages",
			"COUNT(DISTINCT messages.root) AS _totalUnreadConversations",
		);
		$criteria->join = "
			LEFT OUTER JOIN messagerecipients mr ON mr.userId  = $alias.id AND mr.hasRead = 0
				LEFT OUTER JOIN messages ON messages.id = mr.messageId
			";
		$criteria->group = "t.id";
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('email',$this->searchKeyword,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * @return ALogItem[] the activity log for this user
	 */
	public function getActivityLog()
	{
		if ($this->_activityLog === null) {
			$this->_activityLog = array();
			$logFileNames = Yii::app()->introspector->getLogFileNames();
			if (isset($logFileNames['userActivity'])) {
				$logFile = Yii::createComponent(
									"packages.logging.ALogFile",
									$logFileNames['userActivity']
							); /* @var ALogFile $logFile */
			}
			else {
				$logFile = Yii::createComponent(
									"packages.logging.ALogFile",
									array_shift($logFileNames)
							); /* @var ALogFile $logFile */
			}
			foreach($logFile as $item /* @var ALogItem $item */) {
				if ($item->category == "user.activity" &&
					preg_match("/\[". $this->id ."\] (.*)/",$item->title)) {
					$this->_activityLog[] = $item;
				}
			}
		}
		return $this->_activityLog;
	}
}
