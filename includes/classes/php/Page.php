<?php
	require_once Configuration::php_class_dir."Content.php";
	// Page Class
	class Page extends Content{
		// Data not in the abstract Content class
		protected $type;			// page or blog, or custom?
		protected $content;			// HTML for a regular page
		protected $categories;		// Categories to display for a blog
		protected $numPosts;		// Number of posts to show on blog type
		protected $isHome;			// Is this the home page?
		// Getter and Setter for content
		public function content() {
			return $this->content;
		}
		public function SetContent($newContent) {
			$this->content = $newContent;
		}

		public function type() {
			return $this->type;
		}
		public function categories() {
			return $this->categories;
		}
		public function numPosts() {
			return $this->numPosts;
		}
		public function isHome() {
			return $this->isHome;
		}

		// Method for displaying the page
		public function Display() {
			if ($this->status || (isset($_REQUEST['preview']) && $_REQUEST['preview'] == 1)) {
				if ($this->showTitle)
					echo "<h3>".$this->title."</h3>";
				if ($this->type == "page")
					echo $this->content;
				else if ($this->type == "custom")
					eval("?> ".$this->content); //<?php
				else if ($this->type == "blog") {
					if ($this->categories == "all") {
					    $pageNum = 0; // to be used in future updates
						$query = "SELECT * FROM ".Configuration::sitePrefix."posts WHERE status=1 LIMIT ".$pageNum * $this->numPosts.", ".$this->numPosts;
						$result = Configuration::Query($query);
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							$post = new Post($row);
							$post->Display();
						}
					}
					else {
						//print_r($this->categories);
						$pageNum = 0; // to be used in future updates
						$query = "SELECT * FROM ".Configuration::sitePrefix."posts WHERE status=1";$result = Configuration::Query($query);
						$p = 0; // posts printed
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							$post = new Post($row);
							$pcats = $post->categories();
							if (array_intersect($this->categories, $pcats)) {
								$post->Display();
								$p += 1;
							}
						}
					}
				}
			}
			else
				echo "This page is not currently published.";
		}

		// Methods for getting the page
		public function GetByID($pid) {
			if ($pid == "" || $pid == 0) { // get home page
				$query = "SELECT * FROM ".Configuration::sitePrefix."pages WHERE isHome=1";
				$this->FinishGet($query);
			}
			else if ($pid != -2) {
				$query = "SELECT * FROM ".Configuration::sitePrefix."pages WHERE id=$pid";
				$this->FinishGet($query);
			}
		} 
		public function GetByAlias($palias) {
			if (!$palias) 
				$this->GetHome();
			else {
				$query = "SELECT * FROM ".Configuration::sitePrefix."pages WHERE alias='$palias'";
				$this->FinishGet($query);
			}
		}
		public function GetByTitle($ptitle) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."pages WHERE title='$ptitle'";
			$this->FinishGet($query);
		}

		protected function GetHome() {
			$query = "SELECT * FROM ".Configuration::sitePrefix."pages WHERE isHome=1";
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
			}
			else {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$result->free();
				$this->GetRow($row);
			}
		}

		protected function GetRow($row) {
			$this->id = $row['id'];
			$this->content = stripslashes($row['content']);
			$this->title = $row['title'];
			$this->alias = $row['alias'];
			$this->description = $row['description'];
			$this->tags = $row['tags'];
			$this->template = $row['template'] ? $row['template'] : "default";
			$this->status = $row['status'];
			$this->type = $row['type'] ? $row['type'] : "page";
			$this->categories = $row['categories'] ? $row['categories'] : "all";
			if ($this->categories != "all")
				$this->categories = explode(',', $this->categories);
			$this->numPosts = $row['numPosts'] ? $row['numPosts'] : "10";
			$this->security = $row['securelevel'];
			$this->isHome = $row['isHome'];
			$this->error = "";
		}

		public static function GetAll() {
			$query = "SELECT * FROM ".Configuration::sitePrefix."pages ORDER BY id ASC";
			$result = Configuration::Query($query);
			$pages = array();
			if (!$result || Configuration::GetLink()->affected_rows == 0)
				return "Unable to load pages. - ".$query;
			else {
				while ($row = $result->fetch_array(MYSQLI_ASSOC))
					$pages[] = new Page($row);
			}
			return $pages;
		}
	}

?>