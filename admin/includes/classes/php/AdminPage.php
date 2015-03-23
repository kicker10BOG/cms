<?php

	// Admin Page Class
	class AdminPage extends Page {
		// inherits data and generic functions from Page

		// Methods for getting the page
		public function GetByID($pid) {
			if ($pid == "" || $pid == 0) { // get home page
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminPages WHERE id=1";
				$this->FinishGet($query);
			}
			else {
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminPages WHERE id=$pid";
				$this->FinishGet($query);
			}
		}
		public function GetByAlias($palias) {
			if (!$palias)
				$this->GetByID(0);
			else {
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminPages WHERE alias='$palias'";
				$this->FinishGet($query);
			}
		}
		public function GetByTitle($ptitle) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."adminPages WHERE title='$ptitle'";
			$this->FinishGet($query);
		}

		protected function FinishGet($query) {
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0){
				$this->id = -1;
				$this->content = "Sorry, this page could not be found";
				$this->title = "Missing Page";
				$this->description = "This page is missing";
				$this->tags = "";
				$this->template = "default";
				$this->status = 1;
				$this->type = "page";
				$this->security = 0;
				$this->error = "Error loading page - $query - ".Configuration::GetLink()->error;
				$result->free();
			}
			else {
				$row = $result->fetch_array(MYSQLI_ASSOC);
			    //echo "securelevel - ".$row['securelevel']." - ".GLB::GET('userStatus')." - row - ";
			    //print_r($row);
			    if ($row['securelevel'] <= GLB::GET('userStatus')) {
					$this->id = $row['id'];
					$this->content = stripslashes($row['content']);
					$this->title = $row['title'];
					$this->alias = $row['alias'];
					$this->description = $row['description'];
					$this->tags = $row['tags'];
					$this->template = $row['template'];
					$this->status = $row['status'];
					$this->type = $row['type'];
					$this->security = $row['securelevel'];
					$result->free();
				}
				else {
                    $query = "SELECT * FROM ".Configuration::sitePrefix."adminPages WHERE id=5";
                    $this->FinishGet($query);
				}
			}
		}
	}

?>
