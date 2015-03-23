<?php

	// Admin Menu Class
	class AdminMenu extends Menu {
		// inherits data and generic functions from Menu

		public function GetMenu($id) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."adminMenus WHERE id=$id";
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0){
			    echo "Error accessing menu with id: $id";
			}
			else {
				$row = $result->fetch_array();
				$result->free();
				$this->FinishGet($row);
			}
		}

		protected function GetItems($row) {
			// get menu items
			$pattern = '/([0-9]+)/';
			if (preg_match_all($pattern, $row['items'], $itemIDs, PREG_SET_ORDER)) {
				//print_r($itemIDs);
				$query = "";
				foreach($itemIDs as $item)
					$query .= "SELECT * FROM ".Configuration::sitePrefix."adminMenu_items WHERE id=$item[0]; ";
				if (Configuration::MultiQuery($query)) {
					do {
						if ($result = Configuration::GetLink()->store_result()) {
							$row = $result->fetch_array(MYSQLI_ASSOC);
							$menuItem = new AdminMenuItem($row);
							$this->menuItems[] = $menuItem;
							$result->free();
						}
					} while (Configuration::GetLink()->more_results() && Configuration::GetLink()->next_result());
					foreach ($this->menuItems as $item)
					    $item->GetSubMenu();
				}
				else
					echo Configuration::GetLink()->error;
			}
		}
	}

?>
