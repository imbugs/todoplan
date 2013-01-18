<?php
class EmailUtils {
	
	public static function sendYiiMail($to, $subject, $body, $debug = false) {
		$from = 'support@todoplan.net';
		$from = 'todoplan@126.com';
		$message = new YiiMailMessage;
		$message->message->setSubject($subject);
		//$message->view = 'registrationFollowup';
		$message->setBody($body, 'text/html');
		$message->addTo($to);
		$message->from = $from;
		if ($debug) {
			Yii::app()->mail->dryRun = true;
		} else {
			Yii::app()->mail->dryRun = false;
		}
		$result = Yii::app()->mail->send($message);
		return $result;
	}
}
