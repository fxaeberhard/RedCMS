<?PHP

/**
RedCMS - 
The RedMailer extends the PHPMailer class to bridge the parameters of RedCMS to phpmailer.
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
class RedMailer extends PHPMailer {
	public $to = array();
	public $cc = array();
	public $bcc = array();
	function RedMailer(){
		global $redCMS;
		$this->IsHTML(true);
		$this->From = $redCMS->getParam('adminMail');
		$this->FromName = 'Administrator';
		$this->CharSet = $redCMS->charset;
	}
	function From($user){
		$this->From = $user->get('email');
		$this->FromName = $user->getFullName();
		$this->AddReplyTo($user->get('email'));
	}
	function AddAddress($user) {
		$this->to[] = $user;
		parent::AddAddress($user->get('email'), $user->getFullName());
	}
	function AddAddresses($users){
		foreach ($users as &$user){
			$this->AddAddress($user);
		}
	}
	function AddCC($address, $name = '') {
		$this->cc[] = $user;
		parent::AddCC($user->get('email'), $user->getFullName());
	}
	function AddBCC($address, $name = '') {
		$this->bcc[] = $user;
		parent::AddBCC($user->get('email'), $user->getFullName());
	}
	function AddBCCes($users){
		foreach ($users as &$user){
			$this->AddBCC($user);
		}
	}
	function setSubject($sub){
		global $_SERVER;
		$this->Subject = '['.str_replace('www.','', $_SERVER['HTTP_HOST']).']'.$sub;
	}
	function setBody($text){
		global $redCMS;
		$this->Body = $text . $redCMS->getParam('mailFooter');
	}
	function Send(){
		global $redCMS;
		$retour = parent::Send();
		//if(!$retour) {
		//		$redCMS->logger->log("Une erreur est survenu lors de l'envoi du message: <br />".$this->ErrorInfo,'error');
		//} else {
		//		global $redCMS;
//				foreach ($this->to as &$f) $redCMS->logger->log($f->get('email')) ;
//				foreach ($this->cc as &$f) $redCMS->logger->log($f->get('email')) ;
//				foreach ($this->bcc as &$f) $redCMS->logger->log($f->get('email')) ;
		//}
		return $retour;
	}
}