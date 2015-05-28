<?PHP

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class SessionManager {

	var $currentUser;
	var $_SALTLENGTH = 9;
	var $REMEMBERDURATION = 604800; // One month

	/*
	 * TODO update the visitor counter
	 */

	function SessionManager() {
		global $_COOKIE, $_SESSION;

		ini_set('session.gc_maxlifetime', time() + $this->REMEMBERDURATION);
		ini_set('session.cookie_lifetime', time() + $this->REMEMBERDURATION);

		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		if (isset($_SESSION['currentUser'])) {   // If the user is stored in the session var, we load it
			$this->currentUser = $_SESSION['currentUser'];
		} else {
			$this->currentUser = $_SESSION['currentUser'] = new Guest();  // otherwise, we use a Guest user

			$cVisitorCount = $this->getVisitorCount();
			$statement = RedCMS::get()->dbManager->query("UPDATE redcms_variable SET value =  '" . ($cVisitorCount + 1) . "' WHERE name = 'visitorcount'");
			$statement->fetchAll(PDO::FETCH_BOTH);
		}
		if (isset($_SESSION["remember"])) {  // Extend cookie lifetime if it is persistent
			setcookie(session_name(), session_id(), time() + $this->REMEMBERDURATION);
		} else {
			setcookie(session_name(), session_id(), 0);
		}
	}

	function isLoggedIn() {
		return ($this->currentUser instanceof LoggedUser);
	}

	function getCurrentUser() {
		return $this->currentUser;
	}

	function login($username, $password, $remember) {
		$select = (strpos($username, '@') === false) ? 'userName=?' : 'email=?';
		$user = UserManager::getUserBySelect($select, [$username]);
		if ($user && strcmp($user->password, $this->generateHash($password, $user->password)) == 0) {
			if ($remember) {
				$_SESSION["remember"] = true;
			}
			$this->currentUser = $_SESSION['currentUser'] = $user;
			return true;
		} else {
			return false;
		}
	}

	function refreshCurrentUser() {
		$this->currentUser = $_SESSION['currentUser'] = UserManager::getUserBySelect('id=?', [$this->currentUser->fields["id"]]);
	}

	function logout() {
		global $_SESSION;
		$this->currentUser = $_SESSION['currentUser'] = new Guest();
		unset($_SESSION["remember"]);
	}

	function generateHash($plainText, $salt = null) {
		if ($salt === null) {
			$salt = substr(md5(uniqid(rand(), true)), 0, $this->_SALTLENGTH);
		} else {
			$salt = substr($salt, 0, $this->_SALTLENGTH);
		}
		return $salt . sha1($salt . $plainText);
	}

	static function genpassword($size = 8) {
		//on choisit le nombre de lettres
		$letter_nb = mt_rand(3, $size - 2);
		$nb_nb = $size - $letter_nb;
		$pass = [];
		for ($i = 0; $i < $letter_nb; $i++) {
			$n = mt_rand(0, 1);
			//majuscule
			if ($n == 0) {
				$pass[] = chr(mt_rand(65, 90));
			}
			//minuscule
			else {
				$pass[] = chr(mt_rand(97, 122));
			}
		}
		for ($i = 0; $i < $nb_nb; $i++) {
			$pass[] = mt_rand(0, 9);
		}
		shuffle($pass);
		shuffle($pass);
		shuffle($pass);
		return implode('', $pass);
	}

	function getVisitorCount() {
		$statement = RedCMS::get()->dbManager->query("SELECT value FROM redcms_variable WHERE name = 'visitorcount'");
		$rows = $statement->fetchAll(PDO::FETCH_BOTH);
		return $rows[0][0];
	}

	function resetPassword($email) {
		$user = UserManager::getUserBySelect("email=?", [$email]);
		if ($user) {
			$mail = new RedCMSMailer();
			$passwd = $this->genpassword();
			$mail->Subject = 'Réinitialisation de votre password';
			$mail->Body = 'Votre password a été mis à jour. Vos nouvelles coordonnées sont les suivantes:' .
					'<br />' .
					'<br />Username: ' . $user->get('userName') .
					'<br />E-mail: ' . $user->get('email') .
					'<br />Password: ' . $passwd;
			$mail->AddUser($user);
			$retour = $mail->Send();
			if (!$retour) {
				return false;
			} else {
				$user->set('password', $this->generateHash($passwd));
				$user->save();
				return true;
			}
		} else {
			return false;
		}
	}

}
