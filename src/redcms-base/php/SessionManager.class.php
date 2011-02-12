<?PHP
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
class SessionManager {
	var $currentUser;
	var $_SALTLENGTH = 9;
	
	/*
	 * TODO update the visitor counter
	 */
	function SessionManager() {
		session_start();
		
		global $_COOKIE;
		if (isset($_SESSION['currentUser'])) {									// If the user is stored in the session var, we load it
			$this->currentUser = $_SESSION['currentUser'];
		//} else if (isset($_COOKIE['redcms'])) {								// or if there is a cookie, we log using it
		//	$this->login($ckie['user'], $ckie['pass']);
		}else {
			$this->currentUser = $_SESSION['currentUser'] = new Guest();		// otherwise, we use a Guest user
		}
	}

	function isLoggedIn(){
		return !($this->currentUser instanceof Guest);
	}

	function getCurrentUser(){
		return $this->currentUser;
	}
	function login($username, $password){
		global $redCMS;
		$select = (strpos($username, '@') === false)?'userName=?':'email=?';
		$user = UserManager::getUserBySelect($select, array($username));
		if ($user && strcmp($user->fields['password'],
			$this->generateHash($password, $user->fields['password'])) == 0) {

			$this->currentUser = $_SESSION['currentUser'] = $user;

			//FIXME THIS PHASE REQUIRES A MUCH BETTER SECURITY
			//(stock hashed password, userid instead of email, etc...)

			//TODO add log for user connection
			//$CURRENTUC->DBManager->insertFields($CURRENTUC->DB_LOG, array(array('idUser', $field['id'])));
			return true;
		}else return false;
	}
	function logout(){
		global $_SESSION;
		$this->currentUser = $_SESSION['currentUser'] = new Guest();
		//setcookie("redcms-session[user]", "", time()-3600);
	}
	
	function generateHash($plainText, $salt = null)	{
		if ($salt === null) $salt = substr(md5(uniqid(rand(), true)), 0, $this->_SALTLENGTH);
		else $salt = substr($salt, 0, $this->_SALTLENGTH);
		return $salt . sha1($salt . $plainText);
	}
	
	static function genpassword($size = 8){
		//on choisit le nombre de lettres
		$letter_nb = mt_rand(3, $size-2);
		$nb_nb = $size-$letter_nb;
		$pass = array();
		for($i = 0; $i < $letter_nb; $i++){
			$n = mt_rand(0, 1);
			//majuscule
			if($n == 0){
				$pass[] = chr(mt_rand(65, 90));
			}
			//minuscule
			else{
				$pass[] = chr(mt_rand(97, 122));
			}
		}
		for($i = 0; $i < $nb_nb; $i++){
			$pass[] = mt_rand(0, 9);
		}
		shuffle($pass);
		shuffle($pass);
		shuffle($pass);
		return implode('', $pass);
	}
	
	/*
	function isRoot() {
		return $this->getCurrentUser()->get("name") == "root";
	}
	function resetPassword($email){

		global $redCMS;
		$user = $this->getUserByEmail($email);
		//		print_r($user);
		if ( $user ){
			$mail = new RedMailer();
			$passwd = $this->genpassword();
			$redCMS->logger->log($passwd);
			$mail->AddAddress($user);
			$mail->setSubject('Réinitialisation de votre passworda');
			$mail->setBody('Votre password a été mis à jour. Vos nouvelles coordonnées sont les suivantes:'.
				'<br />'.
				'<br />Username: '.$user->get('userName').
				'<br />E-mail: '.$user->get('email').
				'<br />Password: '.$passwd
			);
			$retour = $mail->Send();
			if(!$retour) return $retour;
			else {
				$user->set('password', $passwd);
				$user->save();
				return 'passwordsent';
			}
		} else return 'wrongemail';
	}
	
*/

	/*
	 * OLD FUNCTIONS
	 */
	/**
	 * TODO: only check the users connected since the 3 last hours,
	 * could check if logout, timeout, etc.
	 *
	 * @return unknown an array with logged in users
	 */
	/*
	function whosOnline(){
		global $CURRENTUC;
		return $CURRENTUC->DBManager->getQuery('DISTINCT(uc_users.id) AS id, userName, name, surname',
		array('uc_users', 'uc_log'),
		"idUser=uc_users.id AND uc_log.dateAdded > SUBDATE(NOW(), INTERVAL 3 HOUR) GROUP BY uc_users.id");
	}
	*/
}
?>