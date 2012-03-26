<?php
/**
 * The input form for the {@link AUser} model
 * @var AUser $model The User model
 */
?>
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'nice custom'
	)
)); /* @var CActiveForm $form */
?>


	<?php echo $form->errorSummary($model); ?>

	<div class="form-field">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField(
					$model,
					'name',
					array(
						'placeholder' => "The user's name",
						'class' => 'large input-text',
						'size'=>50,
						'maxlength'=>50
					)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-field">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php
		echo $form->passwordField(
					$model,
					'password',
					array(
						'class' => 'large input-text',
						'placeholder' => "New password for the user",
						'size'=>45,
						'maxlength'=>45
			));
		?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="form-field">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php
		echo $form->textField(
			$model,
			'email',
			array(
				'class' => 'large input-text',
				'placeholder' => "The user's email address",
				'size'=>60,
				'maxlength'=>450
			));
		?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'requiresNewPassword'); ?>
		<?php
		echo $form->checkbox($model,'requiresNewPassword');
		?>
		<?php echo $form->error($model,'requiresNewPassword'); ?>
	</div>
	<div class="row buttons">
		<?php
		echo CHtml::submitButton('Save',array("class" => "nice save button")); ?>
	</div>

<?php $this->endWidget(); ?>
