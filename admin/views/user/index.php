<?php
/**
 * The administration view for the {@link AUser} model
 * @var AUser $model The User model used for searching
 * @var integer $totalActiveUsers the total number of active users
 * @var integer $totalUsers the total number of users
 */
$this->breadcrumbs=array(
	'Users'
);
?>
<header>
	<h1>Site Users</h1>
	<h4 class="subheader">
		<?php
		if ($totalUsers == 1) {
			echo "There is 1 registered user, ";
		}
		else {
			echo "There are ".number_format($totalUsers)." registered users, ";
		}
		echo "of which ";
		if ($totalActiveUsers == 1) {
			echo "1 has activated their account.";
		}
		else {
			echo number_format($totalActiveUsers)." have activated their account.";
		}

?></h4>
	<?php
	$form = $this->beginWidget("CActiveForm",array(
		"method" => "GET",
		"htmlOptions" => array(
			"class" => "nice custom"
		)
	));
	?>
	<div class="row">
		<div class="ten columns">
			<div class="form-field">
			<?php
				echo $form->textField($model,"searchKeyword",array(
					"placeholder" => "Search Users",
					"class" => "full input-text",
				));
			?>
			</div>
		</div>
		<div class="two columns">
			<?php
			echo CHtml::submitButton("Search",array(
				"class" => "nice button"
			))
			?>
		</div>
	</div>
	<?php
	$this->endWidget();
	?>
</header>
<hr />

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
