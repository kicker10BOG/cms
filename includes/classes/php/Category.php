<?php

	// Category Class
	class Category extends Content{
		// Category data
		protected $id;		// Category id
		protected $name;	// Category name
		protected $alias;	// Category alias (the url)
		protected $error;	// holds error info
		protected $page;	// page number
		protected $n;		// number of posts to display
		
		// functions to get data
		public function id() {
			return $this->id;
		}
		public function name() {
			return $this->name;
		}
		public function alias() {
			return $this->alias;
		}
		public function error() {
			return $this->error;
		}
		public function page() {
			return $this->page;
		}
		public function num() {
			return $this->n;
		}
		
		// constructor
		public function __construct($info, $page = 1, $n = 10)  {
			if (isset($info)) {
				if (is_array($info))
					$this->GetRow($info);
				elseif (is_int($info))
					$this->GetByID($info);
				elseif (is_string($info))
					$this->GetByAlias($info);
			}
			$this->template = "default";
			$this->page = $page;
			$this->n = $n;
		}
		
		public function Display() {
			echo $this->content();
		}
		
		// Method for getting the content of the posts in the category
		public function content() {
			$query = "SELECT * FROM `".Configuration::sitePrefix."post-category-relationships` WHERE category=$this->id";
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0) {
				echo "error - $query - ";
				echo Configuration::GetLink()->error;
				return "";
			}
			echo "content!";
			$i = 1;
			$skipped = 0;
			$gathered = 0;			
			$posts = Array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC) && $gathered < $this->n) {
				echo "<br>$skipped<br>$gathered<br>$i<br>".$this->page * $this->n - $this->n;
				if ($skipped == $this->page * $this->n - $this->n) {
					$query2 = "SELECT * FROM ".Configuration::sitePrefix."posts WHERE id=".$row['post']." AND status=1";
					$result2 = Configuration::Query($query2);
					if ($result2 && Configuration::GetLink()->affected_rows == 1){
						$row2 = $result2->fetch_array(MYSQLI_ASSOC);
						$posts[] = new Post($row2);
						$gathered += 1; 
					} 
				}
				else 
					$skipped += 1;
				$i += 1;
			}
			$content = "";
			print_r($posts);
			foreach ($posts as $post) {
				$content = "<h3>".$post->title()."</h3>".$post->content()."<br><hr>";
			}
			return $content;
		}
		
		// Methods for getting the post
		public function GetByID($cid) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."categories WHERE id=$cid";
			$this->FinishGet($query);
		} 
		public function GetByAlias($calias) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."categories WHERE alias='$calias'";
			$this->FinishGet($query);
		} 
		public function GetByTitle($ctitle) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."categories WHERE title='$ctitle'";
			$this->FinishGet($query);
		} 
		protected function FinishGet($query) {
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0){
				$this->id = -1;
				$this->name = "Missing Category";
			}
			else {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$result->free();
				$this->GetRow($row);
			}
		}
		protected function GetRow($row) {
			$this->id = $row['id'];
			$this->name = $row['name'];
			$this->alias = $row['alias'];
		}

		public static function GetAll() {
			$query = "SELECT * FROM ".Configuration::sitePrefix."categories ORDER BY name ASC";
			$result = Configuration::Query($query);
			$categories = array();
			if (!$result || Configuration::GetLink()->affected_rows == 0)
				return "Unable to load categories. - ".$query;
			else {
				while ($row = $result->fetch_array(MYSQLI_ASSOC))
				    $categories[] = new Category($row);
			}
			return $categories;
		}
	}

?>
