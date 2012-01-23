<?php
/**
 * Displays information for a particular {@link User} model
 * @var User $model The User model to show
 */


?>
<div class="row">
	<div class="two columns">
		<strong><?php echo $model->getAttributeLabel("name"); ?></strong>
	</div>
	<div class="ten columns">
		<?php
		echo CHtml::encode($model->name);
		?>
	</div>
</div>
<hr />
<div class="row">
	<div class="two columns">
		<strong><?php echo $model->getAttributeLabel("email"); ?></strong>
	</div>
	<div class="ten columns">
		<?php
		echo CHtml::encode($model->email);
		?>
	</div>
</div>
<hr />
<div class="row">
	<div class="two columns">
		<strong><?php echo $model->getAttributeLabel("requiresNewPassword"); ?></strong>
	</div>
	<div class="ten columns">
		<?php
		echo $model->requiresNewPassword ? "Yes" : "No";
		?>
	</div>
</div>
<hr />
<div class="row">
	<div class="two columns">
		<strong><?php echo $model->getAttributeLabel("registeredAt"); ?></strong>
	</div>
	<div class="ten columns">
		<?php
		echo $model->registeredAt;
		?>
	</div>
</div>
<hr />