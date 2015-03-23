<?php

	// Admin Menu Item Class
	class AdminMenuItem extends MenuItem {
		// inherits data and generic functions from MenuItem

		public function GetSubMenu() {
			if ($this->subMenu) {
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminMenus WHERE id=$this->subMenu";
				$result = Configuration::Query($query);
				if (!$result || Configuration::GetLink()->affected_rows == 0)
					$this->error .= "error loading submenu - $query - ".Configuration::GetLink()->error;
				else {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$result->free();
					$this->subMenu =  new Menu($row);
				}
			}
			// also determine if associated page/post is currently published
			$this->pageStatus = true;
			if ($this->type == "page") {
				$query = "SELECT status FROM ".Configuration::sitePrefix."adminPages WHERE id=$this->pid";
				$result = Configuration::Query($query);
				if ($result || Configuration::GetLink()->affected_rows == 0) {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$this->pageStatus = $row['status'];
					$result->free();
				}
				else {
					$this->pageStatus = false;
					$this->error .= " -- The page for this link was not found: $query - ".Configuration::GetLink()->error." -- ";
				}
			}
			elseif ($this->type == "post")	{
				$query = "SELECT status FROM ".Configuration::sitePrefix."adminPosts WHERE id=$this->pid";
				$result = Configuration::Query($query);
				if ($result || Configuration::GetLink()->affected_rows == 0) {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$this->pageStatus = $row['status'];
					$result->free();
				}
				else {
					$this->pageStatus = false;
					$this->error .= " -- The post for this link was not found: $query -- ".Configuration::GetLink()->error." -- ";
				}
			}
		}
	}

?>
