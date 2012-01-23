<?php
/**
 * A state that represents a user that has deactivated their account.
 *
 * @author Charles Pick
 * @package packages.users.models.states
 */
class ADeactivatedUserState extends AState {
	/**
	 * Declares events and the corresponding event handler methods.
	 * The events are defined by the {@link owner} component, while the handler
	 * methods by the behavior class. The handlers will be attached to the corresponding
	 * events when the behavior is attached to the {@link owner} component; and they
	 * will be detached from the events when the behavior is detached from the component.
	 * @return array events (array keys) and the corresponding event handler methods (array values).
	 */
	public function events() {
		return CMap::mergeArray(parent::events(),array(
			"onBeforeRegister" => "beforeRegister",
			"onBeforeActivate" => "beforeActivate",
			"onBeforeDeactivate" => "beforeDeactivate",
		));
	}
	/**
	 * Raised before a user's account is activated
	 * @param CEvent $event the event being raised
	 * @return boolean whether the account should be activated or not
	 */
	public function beforeActivate($event) {
		return false; // a deactivated user must be reactivated
	}
	/**
	 * Raised before a user's account is deactivated
	 * @param CEvent $event the event being raised
	 * @return boolean whether the account should be deactivated or not
	 */
	public function beforeDeactivate($event) {
		return false; // a deactivated user's account cannot be deactivated, it is already deactivated
	}
	/**
	 * Raised before a user registers
	 * @param CEvent $event the event being raised
	 * @return boolean whether the account should be registered or not
	 */
	public function beforeRegister($event) {
		return false; // a deactivated user's account cannot be registered, it is already registered
	}
}