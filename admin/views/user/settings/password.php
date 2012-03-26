<?php
/**
 * A partial view that allows an administrator to change a user's password
 * @var UserController $this the user controller
 * @var AUser $model the user model
 * @var CActiveForm $form the user form
 */
?>
<h4 class="subheader">Enter a new password in the box below to change the user's existing password.</h4>


<div class="form-field">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password',array('class' => "large input-text")); ?>
	<?php echo $form->error($model,'password'); ?>
</div>
<div class="form-field">
	<?php echo $form->labelEx($model,'requiresNewPassword'); ?>
	<?php echo $form->checkbox($model,'requiresNewPassword'); ?>
	<?php echo $form->error($model,'requiresNewPassword'); ?>
</div>
<br />
<section class="buttons">
	<?php echo CHtml::submitButton("Save",array("class" => "nice save button")); ?>
</section>