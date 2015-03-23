<?php

	// Location Class
	class Location {
		// Location Data
		protected $id;		// Location id
		protected $title;		// Location title
		protected $ordering;  // the menus/mods in order
		protected $items;		// array of active items
		protected $error;		// to hold an error message
		
		public function __construct($id) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."locations WHERE id=$id";
			$result = Configuration::Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0)
			    $this->error = "Error loading location: ".Configuration::GetLink()->error;
			else {
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->id = $row['id'];
				$this->title = $row['title'];
				$this->ordering = explode(',', $row['ordering']);
				$this->items = array();
				
				$types = array();
				$rows = array();
				$query = "";
				foreach ($this->ordering as $item) {
					$item = explode(':', $item);
					$types[] = $item[0];
					$query .= "SELECT * FROM ".Configuration::sitePrefix;
					switch ($item[0]) {
						case "menu": $query .= "menus"; break;
					}
					$query .= " WHERE id=$item[1];";
				}
				if (Configuration::MultiQuery($query)) {
					do {
						$result = Configuration::GetLink()->store_result();
						$row = $result->fetch_array(MYSQLI_ASSOC);
						if (!in_array($row, $rows))
						    $rows[] = $row;
						$result->free();
					} while (Configuration::GetLink()->more_results() && Configuration::GetLink()->next_result());
					$i = 0;
					while ($i < count($rows)) {
						switch ($types[$i]) {
							case "menu": $this->items[] = new Menu($rows[$i]); break;
						}
						$i += 1;
					}
				}
			}
		}
		
		public function Display($orientation) {
		    $out = "";
		    $subMenu = "";
		    //echo "\n\n----$orientation\n\n";
			if ($orientation == "horizontal"){
			    foreach ($this->items as $item){
                    if ($item->parentID() == 0 && $item->status())
						$out .= $item->Horizontal();
					else if ($out != "" && $item->status() && $item->parentID() == Configuration::$content->id() && $item->parentType() == Configuration::$contentType) {
						$subMenu = $item->Horizontal();
					}
				}
				$out .= $subMenu;
			}
			echo $out;
			//print_r($this);
		}
	}

?>
