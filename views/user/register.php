<?php
/**
 * The user registration form
 * @var AUser $model the user model
 */
$this->pageTitle = "Signup Now";
?>
	<h1>Signup Now</h1>
	<h4 class="subheader">Please fill out the form below to signup now.</h4>
	<div class='form'>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>true,
			'htmlOptions' => array(
				'class' => 'nice custom',
			)
		)); ?>
		<div class="form-field">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('placeholder' => 'Please enter your name','class' => 'large text-input','size'=>60,'maxlength'=>450)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<div class="form-field">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('placeholder' => 'Please enter your email address','class' => 'large text-input','size'=>60,'maxlength'=>450)); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="form-field">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('placeholder' => 'Please enter a memorable password','class' => 'large text-input','size'=>60,'maxlength'=>450)); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
		<div class="buttons">
			<?php echo CHtml::submitButton("Signup",array("class" => "nice signup button")); ?>
		</div>

		<?php
		$this->endWidget();
		?>
	</div>
</article>
