<?php
/**
 * Represents a user preference.
 *
 * <pre>
 * $preference = new AUserPreference();
 * $preference->name = "marketingOptIn";
 * $preference->value = true;
 * $preference->userId = Yii::app()->user->id;
 * $preference->save();
 * </pre>
 * @author Charles Pick
 * @package packages.users.models
 *
 * @property string $name the preference name
 * @property integer $userId the user id
 * @property mixed $value the preference value
 */
class AUserPreference extends CActiveRecord {

	/**
	 * Returns the static model instance
	 * @param string $className the class name of the model to instantiate
	 * @return AUserPreference the static model instance
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
	 * Gets the name of the table to use with this model
	 * @return string the name of the table
	 */
	public function tableName() {
		return "userpreferences";
	}
	/**
	 * Gets the validation rules for the model
	 * @return array the validation rules
	 */
	public function rules() {
		return array(
			array("name,value","required"),
			array("name", "checkName"),
			array("value", "checkValue"),
		);
	}

	/**
	 * Checks the preference name
	 * @return boolean whether the name is valid or not
	 */
	public function checkName() {
		if ($this->hasErrors("name")) {
			return false;
		}
		$manager = $this->getPreferenceManager();
		if ($manager->getPreferences()->itemAt($this->name) !== null) {
			return true;
		}
		$this->addError("name", "No such preference");
		return false;
	}

	/**
	 * Checks that the value is valid
	 * @return boolean whether the value is valid or not
	 */
	public function checkValue() {
		if ($this->hasErrors("name") || $this->hasErrors("value")) {
			return false;
		}
		$manager = $this->getPreferenceManager();
		$item = $manager->getPreferences()->itemAt($this->name); /** @var APreference $item */
		if (isset($item->possibleValues[$this->value])) {
			return true;
		}
		$this->addError("name", "Invalid value");
		return false;
	}

	/**
	 * Gets the preference manager
	 * @return APreferenceManager the preference manager
	 */
	public function getPreferenceManager() {
		return Yii::app()->preferenceManager;
	}
}