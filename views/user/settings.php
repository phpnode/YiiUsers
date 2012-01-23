<?php
/**
 * A view that allows the user to edit their settings
 * @var AUserController $this the user controller
 * @var AUser $model the user model
 */
$this->breadcrumbs = array(
	"Your Account" => array("/users/user/account"),
	"Settings"
);
?>
<h3>Your Settings</h3>
<h4 class="subheader">Here you can edit your details and preferences.</h4>
<hr />
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'password-form',
	'action' => array("/users/user/settings"),
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'nice custom'
	)
)); ?>
<?php
$this->widget("TabView",
				array(
					'htmlOptions' => array(

					),
					'tabs' => array(
						'details'=>array(
							  'title'=>'Your Details',
							  'view'=>'settings/details',
							  'data'=>array('model'=>$model, 'form' => $form),
						),
						'preferences'=>array(
							  'title'=>'Your Preferences',
							  'view'=>'settings/preferences',
							  'data'=>array('model'=>$model, 'form' => $form),
						),
						'password'=>array(
							  'title'=>'Your Password',
							  'view'=>'settings/password',
							  'data'=>array('model'=>$model, 'form' => $form),
						),
					)
			));
?>

<?php
$this->endWidget();
?>