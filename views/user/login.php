<?php
/**
 * Displays a form to allow the user to login
 * @var ALoginForm $model The login form model
 */
?>
<h3>Login to your account</h3>
<h4 class="subheader">Please enter your email address and password to login to your account</h4>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action' => array("/users/user/login"),
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'nice custom'
	)
)); /* @var CActiveForm $form */ ?>

<div class="form-field">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>450, "class" => "large input-text")); ?>
	<?php echo $form->error($model,'email'); ?>
</div>
<div class="form-field">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password',array('size'=>60, "class" => "large input-text")); ?>
	<?php echo $form->error($model,'password'); ?>
</div>
<div class="form-field">

	<?php echo $form->label($model,'rememberMe',
							array(
								'label' => $form->checkBox($model,'rememberMe').
										   " ".$model->getAttributeLabel("rememberMe")
							)
						); ?>
	<?php echo $form->error($model,'rememberMe'); ?>
</div>

<div class="buttons">
	<?php echo CHtml::submitButton("Login",array("class" => "nice login button")); ?>
	<?php
		echo CHtml::link("Forgot your password?",array("/users/user/resetPassword"));
	?>
</div>

<?php
$this->endWidget();
?>
