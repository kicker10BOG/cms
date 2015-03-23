<?php

	// Template Class
	class Template {
		// Template data
		protected $id;				// Template ID
		protected $title;			// Template title
		protected $dir;				// Template directory
		protected $isDefault;		// is this the default template?
		protected $banner;			// the banner
		protected $horizSeperator;	// horizontal seperator
		protected $horizSeperator2;	// horizontal seperator for submenus
		protected $vertSeperator;	// verical seperator
		protected $error;			// if an error occurs, it is stored here

		public function __construct($id) {
			if ($id) {
			    if ($id == "default")
			        $query = "SELECT * FROM ".Configuration::sitePrefix."templates WHERE isDefault=1";
				else
					$query = "SELECT * FROM ".Configuration::sitePrefix."templates WHERE id=$id";
				$result = Configuration::Query($query);
				if (!$result || Configuration::GetLink()->affected_rows == 0)
				    $this->error = "<p>Error loading template:</p>".Configuration::GetLink()->error."\n$query";
				else {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					//print_r($row);
					$this->id = $row['id'];
					$this->title = $row['title'];
					$this->dir = "templates/".$row['dir'];
					$this->isDefault = $row['isDefault'];
					$this->banner = $row['banner'];
					$this->horizSeperator = $row['horizSeperator'];
					$this->horizSeperator2 = $row['horizSeperator2'];
					$this->vertSeperator = $row['vertSeperator'];
				}
			}
		}

		public function horizSeperator(){
			return $this->horizSeperator;
		}

		public function horizSeperator2(){
			return $this->horizSeperator2;
		}

		public function vertSeperator(){
			return $this->vertSeperator;
		}

		public function Error() {
			return $this->error;
		}

		public function dir() {
			return $this->dir;
		}

		public function UseTpl() {
		    //echo $this->dir."index.php - ".$this->error;
			include $this->dir."index.php";
		}
	}

?>
