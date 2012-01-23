<?php
/**
 * Manages user preferences.
 *
 * Configuring preference manager in your application config:
 * <pre>
 * "components" => array(
 * 	"preferenceManager" => array(
 * 		"class" => "packages.users.components.APreferenceManager",
 * 		"preferences" => array(
 * 			array(
 * 				"name" => "marketingOptIn",
 * 				"description" => "Do you want to receive occasional emails about services that may be of interest to you?",
 * 				"label" => "Marketing",
 * 				"possibleValues" => array(
 * 					true => "Yes",
 * 					false => "No",
 * 				),
 * 				"defaultValue" => false
 * 			),
 * 			array(
 * 				"name" => "showOnline",
 * 				"description" => "Do you want your name to be included in the list of online users?",
 * 				"label" => "Anonymous Mode",
 * 				"possibleValues" => array(
 * 					true => "Yes",
 * 					false => "No",
 * 				),
 * 				"defaultValue" => false,
 * 			),
 * 		),
 * 	),
 * )
 * </pre>
 *
 * 
 * @author Charles Pick
 * @package packages.users.components
 */
class APreferenceManager extends CApplicationComponent {
	/**
	 * A list of available preferences
	 * @var CTypedMap<APreference>
	 */
	protected $_preferences;


	/**
	 * Sets the available preferences
	 * @param CTypedMap<APreference>|array $preferences the available preferences.
	 */
	public function setPreferences($preferences)
	{
		$prefs = new CTypedMap("APreference");
		foreach($preferences as $name => $preference) {
			if (!($preference instanceof APreference)) {
				if (!isset($preference['class'])) {
					$preference['class'] = "APreference";
				}
				$preference = Yii::createComponent($preference);
			}
			if ($preference->name === null) {
				$preference->name = $name;
			}
			$prefs->add($preference->name,$preference);
		}
		$this->_preferences = $prefs;
	}

	/**
	 * Gets a list of available preferences
	 * @return CTypedMap<APreference>
	 */
	public function getPreferences()
	{
		if ($this->_preferences === null) {
			$this->_preferences = new CTypedMap("APreference");
		}
		return $this->_preferences;
	}
}