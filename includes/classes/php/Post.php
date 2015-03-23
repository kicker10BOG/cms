<?php
	require_once Configuration::php_class_dir."Content.php";
	// Post Class
	class Post extends Content{
		// Data not in the abstract Content class
		protected $content;		// content of the post
		protected $author;		// author of the post
		protected $categories;	// category ids
		// Getter for content
		public function content() {
			return $this->content;
		}
		// Getter for author
		public function author() {
			return $this->author;
		}
		// Getter for content
		public function categories() {
			return $this->categories;
		}
		
		// Method for displaying the page
		public function Display() {
			if ($this->status) {
			    if ($this->showTitle)
					echo "<h3><a style=\"color: black; text-decoration:none;\" href=\"".Configuration::fullHomDir."$this->alias\">$this->title</a></h3>";
				if ($this->showDate)
					echo "<strong>".$this->date()."</strong>";
				echo $this->content;
				return true;
			}
			return false;
		} 
		
		// Update categories
		public function updateCategories($newCategories) {
			foreach ($newCategories as $cat) {
				if (!in_array($cat, $this->categories))
					$this->addCategory($cat);
			}
			foreach ($this->categories as $cat) {
				if (!in_array($cat, $newCategories))
					$this->removeCategory($cat);
			}
			if (count($newCategories) == 0)
			    $this->addCategory(0);
		}
		
		// Add to a category
		public function addCategory($id) {
			$query = "SELECT * FROM `".Configuration::sitePrefix."post-category-relationships` WHERE post=$this->id AND category = $id";
			$result = Configuration::Query($query);
			if ($result && Configuration::GetLink()->affected_rows == 0) {
				$query2 = "INSERT INTO `".Configuration::sitePrefix."post-category-relationships` (post, category) VALUES ($this->id, $id)";
				$result = Configuration::Query($query2);
				$result = Configuration::Query($query);
				if (!($result && Configuration::GetLink()->affected_rows == 1))
				    echo "category not added - $query2 - ".Configuration::GetLink()->error;
			}
		}

		// Remove from a category
		public function removeCategory($id) {
			$query = "SELECT * FROM `".Configuration::sitePrefix."post-category-relationships` WHERE post=$this->id AND category = $id";
			$result = Configuration::Query($query);
			if ($result && Configuration::GetLink()->affected_rows == 1) {
				$query2 = "DELETE FROM `".Configuration::sitePrefix."post-category-relationships` WHERE post=$this->id AND category = $id";
				$result = Configuration::Query($query2);
				$result = Configuration::Query($query);
				if (!($result && Configuration::GetLink()->affected_rows == 0))
				    echo "category not deleted - $query2 - ".Configuration::GetLink()->error;
			}
		}
		
		// Methods for getting the post
		public function GetByID($pid) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."posts WHERE id=$pid";
			$this->FinishGet($query);
		} 
		public function GetByAlias($palias) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."posts WHERE alias='$palias'";
			$this->FinishGet($query);
		} 
		public function GetByTitle($ptitle) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."posts WHERE title='$ptitle'";
			$this->FinishGet($query);
		} 
		protected function FinishGet($query) {
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0){
				$this->id = -1;
				$this->content = "Sorry, this post does not exist";
				$this->title = "Missing Post";
				$this->showTitle = true;
				$this->description = "This post is nonexistent";
				$this->tags = "";
				$this->status = "published";
				$this->categories = Array();
			}
			else {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$result->free();
				$this->GetRow($row);
			}
			$this->template = "default";
		}

		protected function GetRow($row) {
			$this->id = $row['id'];
			$this->content = stripslashes($row['content']);
			$this->title = $row['title'];
			$this->alias = $row['alias'];
			$this->showTitle = $row['showTitle'] ? $row['showTitle'] : true;
			$this->description = $row['description'];
			$this->date = strtotime($row['dateUpdated']) + date("Z");
			$this->showDate = $row['showDate'] ? $row['showDate'] : true;
			$this->tags = $row['tags'];
			$this->showTags = $row['showTags'] ? $row['showTags'] : true;
			$this->status = $row['status'];
			$this->categories = Array();
			if ($row['id'] != NULL) {
				$query = "SELECT * FROM `".Configuration::sitePrefix."post-category-relationships` WHERE post=$this->id";
				$result = Configuration::Query($query);
				if ($result) {
					while ($row = $result->fetch_array(MYSQLI_ASSOC))
						$this->categories[] = $row['category'];
				}
			}
			if (count($this->categories) == 0)
			    $this->categories[] = 0;
		}
		
		public static function GetAll() {
			$query = "SELECT * FROM ".Configuration::sitePrefix."posts ORDER BY id ASC";
			$result = Configuration::Query($query);
			$posts = array();
			if (!$result || Configuration::GetLink()->affected_rows == 0)
				return "Unable to load posts. - ".$query;
			else {
				while ($row = $result->fetch_array(MYSQLI_ASSOC))
				    $posts[] = new Post($row);
			}
			return $posts;
		}
	}

?>
