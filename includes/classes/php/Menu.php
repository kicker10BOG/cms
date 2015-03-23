<?php

	// Menu Class
	class Menu {
	    // Information about the menu
	    protected $id;				// menu id
		protected $title;			// menu title
		protected $parentID;		// parent page/mod
		protected $parentType;		// page/mod/external
		protected $parentChange;	// denotes a change of parent id/type
		protected $parentMenu;		// the parent menu
		protected $parentMenuItem;	// the parent item of this menu
		protected $status;			// is the menu published?
		protected $secureLevel;		// security clearence
		protected $menuItems;		// array of menu items 
		// Display options
		protected $showTitle;
		
		public function __construct($id) {
			if (is_int($id) && $id != 0)
				$this->GetMenu($id);
			elseif (is_array($id))
			    $this->FinishGet($id);
		}
		
		public function Display($orientation) {
			if ($this->status) {
			    echo $this->status;
				if ($orientation == "horizontal")
					echo $this->Horizontal();
			}
		}
		
		public function Horizontal() {
			$out = "";
			foreach ($this->menuItems as $item) {
			    //print_r($item);
				if ($item->status() && $item->pageStatus() && ($item->secureLevel() <= GLB::GET('userStatus'))) {
					if ($this->parentID == 0)
						$out .= Configuration::$tpl->horizSeperator().$item;
					else
					    $out .= Configuration::$tpl->horizSeperator2().$item;
				}
			}
			if ($out != ""){
			    if ($this->parentID == 0)
					$out = "<div class=\"topmenu\">$out".Configuration::$tpl->horizSeperator()."\n"."</div>";
				else if ($this->parentID == Configuration::$content->id() && $this->parentType == Configuration::$contentType)
					$out = "<div class=\"topsubmenu\">$out".Configuration::$tpl->horizSeperator2()."\n"."</div>";
				else
					$out = "<div class=\"topsubmenu\">$out</div>";
				$out = "\n".$out."\n";
			}
			return $out;
		}
		
		public function Dropdown() {
			if ($this->status) {
				$out = "<ul class=\"submenu\">";
				foreach ($this->menuItems as $item) {
					if ($item->status())
						$out .= "<a href=\"".$item->url()."\" target=\"".$item->target()."\"><li>".$item->title()."</li></a>";
				}
				$out .= "</ul>";
				if ($out == "<ul class=\"submenu\"></ul>")
					$out = "";
				return $out;
			}
		}

		public function id() {
			return $this->id;
		}
		public function title($t = NULL) {
			if ($t != NULL) {
				$this->title = $t;
			}
			return $this->title;
		}
		public function parentID($pid = NULL) {
			if ($pid != NULL && $this->parentID != $pid){
				$this->parentChange = true;
				$this->parentID = $pid;
			}
			return $this->parentID;
		}
		public function parentType($pt = NULL) {
			if ($pt != NULL && $this->parentType != $pt){
				$this->parentChange = true;
				$this->parentType = $pt;
			}
			return $this->parentType;
		}
		public function parentMenu($pm = NULL) {
			if ($pm != NULL && $this->parentMenu != $pm){
				$this->parentChange = true;
				$this->parentMenu = $pm;
			}
			return $this->parentMenu;
		}
		public function status($s = NULL) {
			if ($s != NULL){
				$this->status = $s;
			}
			return $this->status;
		}
		public function menuItems() {
			return $this->menuItems;
		}
		
		public function update() {
			$query = "UPDATE ".Configuration::sitePrefix."menus SET title='$this->title', status='$this->status', parentType='$this->parentType', parentID=$this->parentID WHERE id=$this->id";
			$result = Configuration::Query($query);
			echo $query."<br>";
			echo $result."<br>";
			if (!$result)
				echo Configuration::GetLink()->error."<br>";
			else {
				if ($this->parentChange) {
					$query = "UPDATE ".Configuration::sitePrefix."menu_items SET subMenu=0 WHERE subMenu=$this->id";
					$result = Configuration::Query($query); 
					$query = "UPDATE ".Configuration::sitePrefix."menu_items SET subMenu=$this->id WHERE type='$this->parentType' AND pid=$this->parentID AND pMenu='$this->parentMenu'";
					echo $query."<br>";
					$result = Configuration::Query($query);
					if (!$result)
						echo Configuration::GetLink()->error."<br>";
					$this->parentChange = false;
				}
			}
			return $result;
		}
		
		public function GetMenu($id) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."menus WHERE id=$id";
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

		protected function FinishGet($row) {
			// get the menu
			$this->id = $row['id'];
			$this->title = $row['title'];
            $this->parentID = $row['parentID'];
            $this->parentType = $row['parentType'];
            $this->parentMenuItem = $row['parentMenuItem'];
            if ($this->parentMenuItem != 0)
            	$this->parentMenuItem = new MenuItem($this->parentMenuItem);
            $this->parentChange = false;
            $this->parentMenu = $row['parentMenu'];
			$this->status = $row['status'];
			$this->secureLevel = $row['securelevel'];
			$this->menuItems = array();
			$this->showTitle = $row['showTitle'];
			$this->GetItems($row);
		}
		
		protected function GetItems($row) {
			// get menu items
			$query = "SELECT * FROM ".Configuration::sitePrefix."menu_items WHERE pmenu=$this->id ORDER BY `iorder` ASC";
			$result = Configuration::Query($query); 
			if ($result) {
				while ($row = $result->fetch_array(MYSQLI_ASSOC))
					$this->menuItems[] = new MenuItem($row);
				foreach ($this->menuItems as $item) {
					$item->GetPageStatus();
				    $item->GetSubMenu();
				}
			}
		}
		
		public static function GetAll() {
			$query = "SELECT * FROM ".Configuration::sitePrefix."menus ORDER BY id ASC";
			$result = Configuration::Query($query);
			$menus = array();
			if (!$result || Configuration::GetLink()->affected_rows == 0)
				return "Unable to load menus. - ".$query;
			else {
				while ($row = $result->fetch_array(MYSQLI_ASSOC))
				    $menus[] = new Menu($row);
			}
			return $menus;
		}
	}

?>
