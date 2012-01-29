<?php
/**
 * A widget that allows a login form to be embedded on any page
 * @author Charles Pick
 * @package packages.users.widgets
 */
class ALoginWidget extends CWidget {
	/**
	 * The name of the tag that contains the login form
	 * @var string
	 */
	public $tagName = "div";
	/**
	 * The html options for the container tag
	 * @var array
	 */
	public $htmlOptions = array();

	/**
	 * The view file that should be rendered
	 * @var string
	 */
	public $loginView = "packages.users.views.user.login";

	/**
	 * The login form model
	 * @var ALoginForm
	 */
	protected $_model;

	/**
	 * Initializes the widget
	 */
	public function init()
	{
		parent::init();
		ob_start();
	}


	/**
	 * Runs the widget, displays the login form if the user is not logged in
	 */
	public function run() {
		$html = ob_get_clean();
		if (!Yii::app()->user->isGuest) {
			return;
		}

		$html .= $this->getController()->renderPartial(
								$this->loginView,
								array(
									 "model" => $this->getModel()
								),
								true
						);
		echo CHtml::tag($this->tagName,
						$this->htmlOptions,
						$html
					);
	}

	/**
	 * Sets the login form model
	 * @param ALoginForm $model the login form
	 */
	public function setModel($model)
	{
		$this->_model = $model;
	}

	/**
	 * Gets the login form model
	 * @return ALoginForm the login form
	 */
	public function getModel()
	{
		if ($this->_model === null) {
			$config = array();
			$config['class'] = Yii::app()->getModule("users")->loginFormClass;
			$this->_model = Yii::createComponent($config);
		}
		return $this->_model;
	}
}