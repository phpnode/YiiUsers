<?php
/**
 * Displays information for a particular {@link User} model
 * @var User $model The User model to show
 */
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);
?>
<header>

		<h1>View User: <?php echo CHtml::encode($model->name); ?></h1>
		<h4 class="subheader"><?php
			echo "Account Status: ".$model->status;
		?></h4>
		<div class="row">
		<?php
		echo CHtml::link("Edit",array("update", "id" => $model->id),
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

<?php
$this->widget("TabView",array(
	"tabs" => array(
		"details" => array(
			"title" => "Details",
			"content" => $this->renderPartial("_details",array("model" => $model),true),
		),
		"preferences" => array(
				"title" => "Preferences",
				"content" => $this->renderPartial("_preferences",array("model" => $model),true),
			),
		"groups" => array(
			"title" => "Groups",
			"content" => $this->renderPartial("_groups",array("model" => $model),true),
		),
		"roles" => array(
			"title" => "Roles",
			"content" => $this->renderPartial("_roles",array("model" => $model),true),
		),
		"activity" => array(
			"title" => "Activity",
			"content" => $this->renderPartial("_activity", array("model" => $model), true)
		)
	)
));
if (Yii::app()->getModule("users")->enableProfileImages) {
	$this->widget("packages.users.widgets.AUserImageWidget",
			array(
				"user" => $model,
				"htmlOptions" => array(
				"class" => "right thumbnail"
				)
			));
}
?>

