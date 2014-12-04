<?php
	/**
	 * demo AJAX-class
	 *
	 * @author Denis Dragomiric <den@lux-blog.org>
	 * @version Pagen 1.1.6
	 */

	namespace Controllers\Ajax\auth;
	\Pagen\ajaxSettings (['Config', 'DataBase']);

	class login extends \Pagen\eAjaxController {
		private $message;
		private $login;
		private $pass;

		function request () {
			$this->login = $_REQUEST ['login'];
			$this->pass  = $_REQUEST ['pass'];
		}

		function run () {
			if (\config::DB) {
				$this->is_mysql ();
			} else {
				$this->not_mysql ();
			}
		}

		function response () {
			return $this->message;
		}

		private function not_mysql () {
			if ($this->login == \config::ADMIN and $this->pass == \RandKey::demask(\config::PASS)) {
				session_start();
				$_SESSION ['id'] = 0;
				$_SESSION ['rights'] = 6;
				$this->message = 'You are logged in!';
			} else {
				$this->message = 'Error: check your login and password!';
			}
		}
		private function is_mysql () {
			$mysqli = \DataBase::$mysqli;
			if (!\Validator::login ($this->login)) {
				$this->message = \PageLang::alert (8);
			} else {
				$query = $mysqli->query ("SELECT `id`,`rights`,`pass` FROM `".\config::PREFIX."users` WHERE `login`='{$this->login}'");
				$result = $query->fetch_assoc ();
				if ($query->num_rows == 0 or $this->pass != \RandKey::demask ($result['pass'])) {
					$this->message = \PageLang::alert (8);
				} else {
					session_start ();
					$_SESSION ['id'] = $result ['id'];
					$_SESSION ['rights'] = $result ['rights'];
					$this->message = '200 OK';
				}
			}
		}
	}
?>
