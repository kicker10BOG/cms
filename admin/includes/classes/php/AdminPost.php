<?php

	// Admin Post Class
	class AdminPost extends Post {
		// inherits data and generic functions from Post

		// Methods for getting the post
		public function GetByID($pid) {
			if ($pid == "" || $pid == 0) { // get home post
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminPosts WHERE id=1";
				$this->FinishGet($query);
			}
			else {
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminPosts WHERE id=$pid";
				$this->FinishGet($query);
			}
		}
		public function GetByAlias($palias) {
			if (!$palias)
				$this->GetByID(0);
			else {
				$query = "SELECT * FROM ".Configuration::sitePrefix."adminPosts WHERE alias='$palias'";
				$this->FinishGet($query);
			}
		}
		public function GetByTitle($ptitle) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."adminPosts WHERE title='$ptitle'";
			$this->FinishGet($query);
		}

		protected function FinishGet($query) {
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0){
				$this->id = -1;
				$this->content = "Sorry, this post could not be found";
				$this->title = "Missing Post";
				$this->description = "This post is missing";
				$this->tags = "";
				$this->template = "default";
				$this->status = 1;
				$this->type = "post";
				$this->security = 0;
				$this->error = "Error loading post - $query - ".Configuration::GetLink()->error;
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
                    $query = "SELECT * FROM ".Configuration::sitePrefix."adminPosts WHERE id=5";
                    $this->FinishGet($query);
				}
			}
		}
	}

?>
