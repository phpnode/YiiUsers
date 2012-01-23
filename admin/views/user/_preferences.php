<?php
/**
 * A partial view that allows an administrator to view a user's preferences
 * @var UserController $this the user controller
 * @var AUser $model the user model
 */

$preferences = Yii::app()->preferenceManager->getPreferences();

?>
<?php
foreach($preferences as $preference):
?>
	<div class="row">
		<div class="three columns">
			<strong><?php echo CHtml::encode($preference->label); ?></strong>
		</div>
		<div class="nine columns">
			<?php
				$possibleValues = $preference->possibleValues;
				echo $possibleValues[$model->getPreference($preference->name)];
			?>
		</div>
	</div>
	<hr />
<?php
endforeach;
?>