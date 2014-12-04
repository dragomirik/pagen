<?php
	/**
	 * demo class
	 *
	 * @author Denis Dragomiric <den@lux-blog.org>
	 * @version Pagen 1.1.6
	 */
	namespace Data;
	use \Pagen\DataBase;
	use \Pagen\User;

	class Design {
		public function createMenu ($word) {
			$mysqli = &DataBase::$mysqli;
			$user_prioritet = User::$userInfo ['rights'] + 1;
			$menu = array ();
			$menu_query = $mysqli->query ("SELECT * FROM `".
				\config::PREFIX."pages` WHERE `show` <= '$user_prioritet' AND `show` != '0' ORDER BY `hor_menu` ASC");
			$menu_row = $menu_query->fetch_assoc ();
			$i = 0;
			do {
				$title_index = $menu_row ['title'];
				$menu_row ['title'] = $word [$title_index];
				if ($menu_row ['cpurl'] == '/') {
					$menu_row ['cpurl'] = '';
				}
				// replace title of pages for menu from language array

				$menu [$i] ['title'] = $menu_row ['title'];
				$menu [$i] ['cpurl'] = $menu_row ['cpurl'];
				//get menu array
				$i ++;
			} while ($menu_row = $menu_query->fetch_assoc ());
			//forming horisontal menu
			return $menu;
		}

		public static function getDefaultFilesArray () {
			return [
				'hor_menu' => 'blocks'.DIRSEP.'hor_menu',
				'sign_in_form' => 'blocks'.DIRSEP.'sign_in_form'
			];
		}
	}
?>