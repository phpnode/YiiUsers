<?php
/**
 * Displays a password reset form
 * @var AUser $model the model to reset the password for
 */
$this->pageTitle = "Reset Your Password";
?>
	<h3>Reset Your Password</h3>
	<h4 class="subheader">Please enter your email address in the box below, and we'll send you a link to reset your password.</h4>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		'htmlOptions' => array(
			'class' => 'nice custom',
		),
		'enableAjaxValidation'=>true,
	)); ?>
	<div class="form-field">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>450)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<br />
	<div class="buttons">
		<?php echo CHtml::submitButton("Reset Password",array("class" => "nice blue button")); ?>
	</div>

	<?php
	$this->endWidget();
	?>