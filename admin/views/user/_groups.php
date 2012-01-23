<?php
/**
 * Displays information for a particular {@link User} model
 * @var User $model The User model to show
 */
?>
<p class="subheader"><?php echo CHtml::encode($model->name)." belongs to ".$model->totalGroups." group(s)"; ?></p>
