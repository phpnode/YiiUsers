<?php
/**
 * A state that represents a user that has not yet activated their account.
 *
 * @author Charles Pick
 * @package packages.users.models.states
 */
class APendingUserState extends AState {
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
			"onBeforeDeactivate" => "beforeDeactivate",
			"onBeforeReactivate" => "beforeReactivate",
		));
	}
	/**
	 * Raised before a user's account is deactivated
	 * @param CEvent $event the event being raised
	 * @return boolean whether the account should be deactivated or not
	 */
	public function beforeDeactivate($event) {
		return false; // a pending user's account cannot be deactivated, it was never active
	}
	/**
	 * Raised before a user's account is reactivated
	 * @param CEvent $event the event being raised
	 * @return boolean whether the account should be reactivated or not
	 */
	public function beforeReactivate($event) {
		return false; // a pending user's account cannot be reactivated, it was never active
	}
}