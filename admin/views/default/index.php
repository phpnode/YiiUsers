<?php
/**
 * Summary page for the user admin module.
 *
 * @var integer $totalActiveUsers the total number of active users
 * @var integer $totalUsers the total number of users
 */
?>
<header>
	<h2>Site Users</h2>
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
</header>
<hr />