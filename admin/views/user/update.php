<?php
/**
 * A view used to update {@link User} models
 * @var User $model The User model to be updated
 */
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
?>

<header>

	<h1>Edit User: <?php echo CHtml::encode($model->name); ?></h1>
	<h4 class="subheader"><?php
		echo "Account Status: ".$model->status;
	?></h4>
	<div class="row">
		<?php
		echo CHtml::link("View",array("view", "id" => $model->id),
				array(
					"class" => "left small nice button"
				));
		echo CHtml::linkButton("Impersonate",
						array(
							'submit'=>array('impersonate','id'=>$model->id),
							'confirm'=>'Are you sure you want to impersonate this user? You will be logged out of your account and will have to log back in to access the admin section.',
							'class' => 'left small nice white button'
						));
		if ($model->is("pending")) {
			echo CHtml::linkButton("Activate",
						array(
							'submit'=>array('activate','id'=>$model->id),
							'class' => 'left small nice white button'
						));
		}
		elseif ($model->is("active")) {
			echo CHtml::linkButton("Deactivate Account",
						array(
							'submit'=>array('deactivate','id'=>$model->id),
							'confirm' => 'Are you sure you want to deactivate this user\'s account? They will no longer be able to login to the site.',
							'class' => 'left small nice white button'
						));
		}
		elseif ($model->is("deactivated")) {
			echo CHtml::linkButton("Reactivate Account",
						array(
							'submit'=>array('reactivate','id'=>$model->id),
							'class' => 'left small nice white button'
						));
		}
		echo CHtml::linkButton("Delete",
							array(
								'submit'=>array('delete','id'=>$model->id),
								'confirm'=>'Are you sure you want to delete this item?',
								'class' => 'right small nice white button'
							));
		?>
		</div>
</header>
<hr />

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'class' => 'nice custom'
	)
)); ?>
<?php
$this->widget("TabView",
				array(
					'htmlOptions' => array(

					),
					'tabs' => array(
						'details'=>array(
							  'title'=>'User Details',
							  'view'=>'settings/details',
							  'data'=>array('model'=>$model, 'form' => $form),
						),
						'preferences'=>array(
							  'title'=>'User Preferences',
							  'view'=>'settings/preferences',
							  'data'=>array('model'=>$model, 'form' => $form),
						),
						'password'=>array(
							  'title'=>'User Password',
							  'view'=>'settings/password',
							  'data'=>array('model'=>$model, 'form' => $form),
						),
					)
			));
?>

<?php
$this->endWidget();
?>