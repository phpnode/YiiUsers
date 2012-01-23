<?php
/**
 * Displays information for a particular {@link User} model
 * @var User $model The User model to show
 */
?>
<?php
	echo CHtml::link(
			"New Role",
			array("/admin/rbac/role/create", "assignTo" => $model->id),
			array(
				"class" => "right small nice button"
			)
	);
	?>
	<p class='subheader'>Select the roles that this user belongs to, drag the roles between the lists to select them.</p>
	<div class="row">
		<section class='six columns'>
			<h4>Selected Roles</h4>
			<p class="subheader">This user belongs to these roles.</p>
			<?php
			$csrfData = json_encode(array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken));
			$ajax = CHtml::ajax(array(
								"url" => array("setRoles","id" => $model->id),
								"type" => "POST",
								"data" => 'js:(function(){
									var data = '.$csrfData.';
									data.roles = $("#selectedRoles").sortable("toArray");
									return data;
								}())',
								"success" => "function(res){
									$('#unselectedRoles li.ui-state-highlight').
										removeClass('ui-state-highlight').
										addClass('ui-state-default');
									$('#selectedRoles li.ui-state-default').
										removeClass('ui-state-default').
										addClass('ui-state-highlight');
								}"
						));
			$selectedRoles = array();
			foreach($model->roles as $item) {
				$selectedRoles[$item->name] = $item->createLink(null,null,array("title" => $item->description));
			}
			$unselectedRoles = array();
			foreach(AAuthRole::model()->findAll() as $item) {
				if (isset($selectedRoles[$item->name])) {
					continue;
				}
				$unselectedRoles[$item->name] = $item->createLink(null,null,array("title" => $item->description));
			}

			$this->widget('zii.widgets.jui.CJuiSortable', array(
					'id' => "selectedRoles",
					'itemTemplate' => '<li id="{id}" class="ui-state-highlight"><span class="ui-icon ui-icon-arrowthick-2-e-w left"></span>&nbsp;&nbsp;{content}</li>',

					'items'=>$selectedRoles,
					// additional javascript options for the accordion plugin
					'options'=>array(
						'connectWith' => '#unselectedRoles',
						'update' => 'js:function(event,ui){ '.$ajax.' }',
						'delay' => 300,
					),
			));
			?>
		</section>
		<section class='six columns'>
			<h4>Unselected Roles</h4>
			<p>This user does not belong to these roles.</p>
			<?php
			$this->widget('zii.widgets.jui.CJuiSortable', array(
				'id' => "unselectedRoles",
				'itemTemplate' => '<li id="{id}" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-e-w left"></span>&nbsp;&nbsp;{content}</li>',
				'items'=>$unselectedRoles,
				// additional javascript options for the accordion plugin
				'options'=>array(
						'connectWith' => '#selectedRoles',
						'delay' => 300,
				),
			));
			?>
		</section>
	</div>