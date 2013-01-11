<?php
/**
 * Displays a login form and logs the user in to the site
 * @package packages.users.components
 * @author Charles Pick
 */
class ALoginAction extends CAction {
	/**
	 * Displays the login form and authenticates the user
	 */
	public function run() {
		$loginFormClass = Yii::app()->getModule("users")->loginFormClass;
		$loginForm = new $loginFormClass; /* @var ALoginForm $loginForm */
		$controller = $this->controller;
		$this->performAjaxValidation($loginForm);
		if (isset($_POST[$loginFormClass])) {
			$loginForm->attributes = $_POST[$loginFormClass];
			if ($loginForm->validate()) {
				$loginForm->login();
				$user = Yii::app()->user->getModel(); /* @var AUser $user */
				Yii::log("[".$user->id."] Logged in","info","user.activity.login");
				if ($user->requiresNewPassword) {
					$controller->redirect(array("/users/user/changePassword"));
				}
				$controller->redirect(Yii::app()->user->getReturnUrl(array("/users/user/account")));
			}
		}

		if (Yii::app()->request->isAjaxRequest) {
			$controller->renderPartial("login",array("model" => $loginForm), false, true);
		}
		else {
			$controller->render("login",array("model" => $loginForm));
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param ALoginForm $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
