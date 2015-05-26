<?PHP

/**
  RedCMS -
  The RedMailer extends the PHPMailer class to bridge the parameters of RedCMS to phpmailer.
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */
class RedCMSMailer extends PHPMailer {

	function __construct() {
		parent::__construct(false);
		//parent::__construct(true);
		$redCMS = RedCMS::get();
		$this->IsHTML(true);
		$this->From = $redCMS->config['adminMail'];
		$this->FromName = 'Administrator';
		$this->CharSet = $redCMS->config['charset'];

		if ($redCMS->config['smtpMode']) {
			$this->IsSMTP();
			$this->Host = $redCMS->config['smtpHost'];
			$this->Port = $redCMS->config['smtpPort'];
			$this->SMTPAuth = $redCMS->config['smtpAuth'];
			$this->Username = $redCMS->config['smtpUsername'];
			$this->Password = $redCMS->config['smtpPassword'];
			$this->Mailer = "smtp";
			//$this->SMTPDebug = true;
		}
	}

	function AddUser($u) {
		$this->AddAddress($u->email, $u->getLabel());
	}

	function Send() {
		return parent::Send();
	}

}
