<?php
/**
 * Represents a site preference.
 * Preferences can affect how the site behaves for individual users.
 * @author Charles Pick
 * @package packages.users.components
 */
class APreference extends CComponent {
	/**
	 * The name of the preference.
	 * @var string
	 */
	public $name;

	/**
	 * The label to display for the preference
	 * @var string
	 */
	public $label;

	/**
	 * A description of the preference
	 * @var string
	 */
	public $description;

	/**
	 * The possible values of the preference.
	 * This should be an array with the format possibleValue => label
	 * @var array
	 */
	public $possibleValues = array();

	/**
	 * The default value
	 * @var mixed
	 */
	public $defaultValue;
}