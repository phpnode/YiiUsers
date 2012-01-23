<?php
/**
 * A partial view that allows the user to edit their site preferences
 * @var AUserController $this the user controller
 * @var AUser $model the user model
 * @var CActiveForm $form the user form
 */

$preferences = Yii::app()->preferenceManager->getPreferences();
?>
<h4 class="subheader">These settings affect how the site behaves for you.</h4>
<?php
foreach($preferences as $preference):
?>
<div class="form-field">
	<?php echo $form->labelEx($model,'preferences['.$preference->name.']',array("label" => $preference->label)); ?>
	<?php
	echo CHtml::dropDownList(get_class($model)."[preferences][".$preference->name."]",$model->getPreference($preference->name),$preference->possibleValues);
	?>
	<?php echo $form->error($model,'preferences['.$preference->name.']'); ?>
</div>
<?php
endforeach;
?>
<br />
<section class="buttons">
	<?php echo CHtml::submitButton("Save",array("class" => "nice save button")); ?>
</section>