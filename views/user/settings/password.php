<?php
/**
 * A partial view that allows the user to change their password
 * @var AUserController $this the user controller
 * @var AUser $model the user model
 * @var CActiveForm $form the user form
 */
?>
<h4 class="subheader">Enter a new password in the box below to change your existing password.</h4>


<div class="form-field">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password',array('class' => "large input-text")); ?>
	<?php echo $form->error($model,'password'); ?>
</div>
<br />
<section class="buttons">
	<?php echo CHtml::submitButton("Change Password",array("class" => "nice save button")); ?>
</section>