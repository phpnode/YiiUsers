<?php
/**
 * A dummy user controller class
 * @package packages.users.controllers
 */
class UserController extends AUserController {
	public function actionAccount() {
		$this->forward("settings"); // override default
	}
}
