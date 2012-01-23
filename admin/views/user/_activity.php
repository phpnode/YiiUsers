<?php
/**
 * Displays recent site activity for a particular {@link User} model
 * @var User $model The User model to show
 */

$logRoute = Yii::app()->log->routes['userActivity']; /* @var CFileLogRoute $logRoute */
$logFilename = $logRoute->logPath.DIRECTORY_SEPARATOR.$logRoute->logFile;
$this->widget("packages.logging.ALogViewerWidget",array(
	"logFile" => $logFilename,
	"filterCallback" => function($item) use($model) {
		if (
				$item->category == "user.activity" &&
				preg_match("/^\[". $model->id ."\] (.*)/",$item->title,$matches)
			) {
			$item->title = $matches[1];
			return true;
		}
		return false;
	}
));