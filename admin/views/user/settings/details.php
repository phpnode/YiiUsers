<?php
/**
 * A partial view that allows an administrator to edit a user's details
 * @var AUserController $this the user controller
 * @var AUser $model the user model
 * @var CActiveForm $form the user form
 */
?>
<h4 class="subheader">User's contact details.</h4>
<div class="form-field">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>450, "class" => "large input-text")); ?>
	<?php echo $form->error($model,'name'); ?>
</div>

<div class="form-field">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>450, "class" => "large input-text")); ?>
	<?php echo $form->error($model,'email'); ?>
</div>
<br />
<section class="buttons">
	<?php echo CHtml::submitButton("Save",array("class" => "nice save button")); ?>
</section>