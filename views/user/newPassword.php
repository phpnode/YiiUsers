<?php
/**
 * Allows the user to enter a new password
 * @var AUser $model the model to change the password for
 */
$this->pageTitle = "Enter A New Password";
?>
<header>
	<h1>Enter A New Password</h1>
	<h4 class='subheader'>Please enter a new password in the form below to continue.</h4>
</header>
<hr />
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'htmlOptions' => array(
		'class' => 'nice custom'
	),
	'enableAjaxValidation'=>true,
)); /* @var CActiveForm $form */?>
<div class="form-field">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password',array(
		"class" => "large input-text",
		"placeholder" => "Enter A New Password"
	)); ?>
	<?php echo $form->error($model,'password'); ?>
</div>

<div class="button-column">
	<?php echo CHtml::submitButton("Save",array("class" => "nice save button")); ?>
</div>

<?php
$this->endWidget();
?>