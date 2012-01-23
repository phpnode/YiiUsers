<?php
/**
 * Shows the user's account page
 * @var AUserController $this the controller
 * @var AUser $model The user model
 */
$this->layout = "//layouts/main";
$this->menu = array(
	array(
		"label" => "Test",
		"url" => array("/site/index")
	),
);
?>
<h3>Your Account</h3>
<h4 class="subheader">Here you can edit your settings.</h4>
<hr />
<div class="row">
	<div class="two columns">
	<?php
	$this->widget("zii.widgets.CMenu",
					array(
	   					"items" => array(
							   array(
								   "label" => "News Feed",
								   "url" => array("/users/user/account"),
							   ),
							   array(
								   "label" => "Messages",
								   "url" => array("/users/user/messages"),
							   ),
							   array(
								   "label" => "Settings",
								   "url" => array("/users/user/settings"),
							   )
						   )
					));
	?>
	</div>
	<div class="seven columns">
		<div class="row">
			<div class="two columns">
			<?php
			$this->widget("packages.users.widgets.AUserImageWidget",array(
				"user" => $model,
			));
			?>
			</div>
			<div class="ten columns">
				<?php echo CHtml::link($model->name,"/"); ?>
				<br /><br />
				<div class="row">
					<div class="four columns">
						<img src='//placehold.it/200x200' />
					</div>
					<div class="eight columns">
						blah blah blah
					</div>
				</div>
				<section class="comments">
					  <div class="row">
						  <div class="two columns">
							  <img src="http://placehold.it/50x50" />
						  </div>
						  <div class="ten columns"><a href="">TheColonel</a> says "Don't get too comfy, I'm coming for that tree."</div>
					  </div>
					  <div class="row">
						  <div class="two columns">
							  <img src="http://placehold.it/50x50" />
						  </div>
						  <div class="ten columns"><a href="">Jake</a> says "You're such a tool."</div>
					  </div>
				  </section>

			</div>
		</div>
		<hr />
		<div class="row">
			<div class="two columns">
			<?php
			$this->widget("packages.users.widgets.AUserImageWidget",array(
				"user" => $model,
			));
			?>
			</div>
			<div class="ten columns">
				<?php echo CHtml::link($model->name,"/"); ?>
				<br /><br />
				<div class="row">
					<div class="four columns">
						<img src='//placehold.it/200x200' />
					</div>
					<div class="eight columns">
						blah blah blah
					</div>
				</div>
				<section class="comments">
					  <div class="row">
						  <div class="two columns">
							  <img src="http://placehold.it/50x50" />
						  </div>
						  <div class="ten columns"><a href="">TheColonel</a> says "Don't get too comfy, I'm coming for that tree."</div>
					  </div>
					  <div class="row">
						  <div class="two columns">
							  <img src="http://placehold.it/50x50" />
						  </div>
						  <div class="ten columns"><a href="">Jake</a> says "You're such a tool."</div>
					  </div>
				  </section>

			</div>
		</div>
	</div>
	<div class="three columns">
			Last sidebar content goes here
		</div>
</div>