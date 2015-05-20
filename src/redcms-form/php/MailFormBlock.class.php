<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class MailFormBlock extends FormBlock {
	/* function parseRequest(){
	  global $_REQUEST;
	  $redCMS = RedCMS::get();
	  $fields = parent::parseRequest();

	  foreach ($fields as &$f) {
	  switch ($f['type']) {
	  case 'TextareaField':
	  case 'EditorField':
	  $f['value'] .= $redCMS->config['mailFooter'];
	  default:
	  break;
	  }
	  }

	  return $fields;
	  } */

	function render() {
		global $_REQUEST, $_SERVER;
		$redCMS = RedCMS::get();
		if (isset($_REQUEST['redaction'])) {
			$ret = true;
			$mail = new RedCMSMailer();
			$user = $redCMS->sessionManager->getCurrentUser();
			if ($user->email) {
				$mail->From = $user->email;
				$mail->FromName = $user->getLabel();
			} else {
				$mail->From = 'anonymous@anonymous.com';
			}
			$fields = $this->parseRequest();

			$mail->Subject = '[' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . ']' . $fields['msg_title'];
			$mail->Body = $fields['msg_content'] . $redCMS->config['mailFooter'];

			foreach (UserManager::getUsersByGroupId($fields['dest_group']) as $u) {
				$mail->AddUser($u);
				$r = $mail->Send();
				if ($r !== true) {
					//$redCMS->log($msg, 'log', 'MailFormBlock');
					$ret = false;
				}
				$mail->ClearAllRecipients();
			}
			if ($ret) {
				$msg = 'Mail sent.'; //. to group number '.$_REQUEST['dest_group'];
				//$redCMS->log($msg, 'log', 'MailFormBlock');
				$ret = array('result' => 'success', 'msg' => $msg);
			} else {
				$msg = 'Error sending mail to group ' . $_REQUEST['dest_group'];
				//$redCMS->log($msg, 'error', 'MailFormBlock');
				$ret = array('result' => 'error', 'msg' => $msg);
			}
			echo json_encode($ret);
		} else
			echo parent::render();
	}

}

?>