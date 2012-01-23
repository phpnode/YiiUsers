<?php
/**
 * Represents a web application user.
 * @author Charles Pick
 * @package packages.users.components
 */
class AWebUser extends CWebUser {
	/**
	 * The URL for login.
	 * @var array
	 */
	public $loginUrl = array("/users/user/login");
	/**
	 * Holds the model for the currently logged in user
	 * @see getModel()
	 * @see setModel()
	 * @var AUser
	 */
	protected $_model;

	/**
	 * Gets the user model for the currently logged in user
	 * @return AUser the model for the logged in user, or false if the user is not logged in
	 */
	public function getModel() {
		if ($this->getIsGuest()) {
			return false;
		}
		if ($this->_model === null) {
			$modelClass = Yii::app()->getModule("users")->userModelClass;
			$this->_model = $modelClass::model()->findByPk($this->getId());
		}
		return $this->_model;
	}
	/**
	 * Sets the model for the currently logged in user
	 * @param AUser $model the user model
	 * @return AUser $model the user model
	 */
	public function setModel(AUser $model) {
		return $this->_model = $model;
	}
}