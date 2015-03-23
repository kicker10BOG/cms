<?php

	// MenuItem Class
	class MenuItem {
		// MenuItem data
		protected $id;			// MenuItem ID
		protected $title;		// the title
		protected $pmenu;		// parent menu
		protected $type;		// page/post/mod/external
		protected $pid;			// page/pst/mod id
		protected $pageStatus;	// the status of the associate page/post/mod
		protected $url;			// the url to page/post/mod/external
		protected $target;		// open in parent or new tab/window
		protected $status;		// is it active or not?
		protected $secureLevel;	// security level
		protected $subMenu;		// some items have submenus
		protected $order;		// the order of the item in the menu
		protected $error = "";	// holds error info

		public function __construct($id) {
			if (is_int($id) && $id != 0)
				$this->GetItem($id);
			elseif (is_array($id))
			    $this->GetRow($id);
		}
		//public function __construct($id) {
		//    if (is_array($id)) {
		//    	$this->GetRow($id);
		//	}
		//}
		
		public function id() {
			return $this->id;
		}
		public function title($t = NULL) {
			if ($t != NULL) {
				$this->title = $t;
			}
			return $this->title;
		}
		public function pmenu($pm = NULL) {
			if ($pm != NULL) {
				$this->pmenu = $pm;
			}
			return $this->pmenu;
		}
		public function type($t = NULL) {
			if ($t != NULL) {
				$this->type = $t;
			}
			return $this->type;
		}
		public function pid($pid = NULL) {
			if ($pid != NULL) {
				$this->pid = $pid;
			}
			return $this->pid;
		}
		public function pageStatus($s = NULL) {
			if ($s != NULL) {
				$this->pageStatus = $s;
			}
			return $this->pageStatus;
		}
		public function url($url = NULL) {
			if ($url != NULL) {
				$this->url = $url;
			}
			return $this->url;
		}
		public function target($t = NULL) {
			if ($t != NULL) {
				$this->target = $t;
			}
			return $this->target;
		}
		public function status($s = NULL) {
			if ($s != NULL) {
				$this->status = $s;
			}
			return $this->status;
		}
		public function secureLevel($sl = NULL) {
			if ($sl != NULL) {
				$this->secureLevel = $sl;
			}
			return $this->secureLevel;
		}
		public function subMenu($m = NULL) {
			if ($m != NULL) {
				$this->subMenu = $m;
			}
			return $this->subMenu;
		}
		public function order($o = NULL) {
			if ($o != NULL) {
				$this->order = $o;
			}
			return $this->order;
		}
		public function error() {
			return $this->error;
		}
		
		public function GetItem($id) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."menu_items WHERE id=$id";
			print("<br>".$query."<br>");
			$result = Configuration::Query($query);//Query($query);
			if (!$result || Configuration::GetLink()->affected_rows == 0){
			    echo "Error accessing menu with id: $id";
			}
			else {
				// get the menu
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->GetRow($row);
			}
		}
		
		private function GetRow($row) {
				$this->id = $row['id'];
				$this->title = $row['title'];
				$this->pmenu = $row['pmenu'];
				$this->type = $row['type'];
				$this->pid = $row['pid'];
				$this->url = $row['url'];
				$this->target = $row['target'];
				$this->status = $row['status'];
				$this->secureLevel = $row['securelevel'];
				$this->subMenu = $row['subMenu'];
				$this->order = $row['iorder'];
				
				//$this->GetPageStatus();
		}
		
		public function GetPageStatus() {
			$this->pageStatus = true;
			if ($this->type == "page") {
				$query = "SELECT status FROM ".Configuration::sitePrefix."pages WHERE id=$this->pid";
				$result = Configuration::Query($query);
				if ($result || Configuration::GetLink()->affected_rows != 0) {
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
				$query = "SELECT status FROM ".Configuration::sitePrefix."posts WHERE id=$this->pid";
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
		
		public function GetSubMenu() {
			if ($this->subMenu) {
				$query = "SELECT * FROM ".Configuration::sitePrefix."menus WHERE id=$this->subMenu";
				$result = Configuration::Query($query);
				if (!$result || Configuration::GetLink()->affected_rows == 0)
					$this->error = "error loading submenu - $query - ".Configuration::GetLink()->error;
				else {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$result->free();
					$this->subMenu =  new Menu($row);
				}
				//$this->GetPageStatus();
			}
		}
		
		public function update() {
			if ($this->pid == 0) {
				return true;
			}
			if ($this->type == "page") {
				$query = "SELECT alias FROM ".Configuration::sitePrefix."pages WHERE id=".$this->pid;
				$result = Configuration::Query($query);
				if (!$result)
					return false;
				$row = $result->fetch_array(MYSQL_ASSOC);
				$this->url("/".$row['alias']);
			}
			$query = "UPDATE ".Configuration::sitePrefix."menu_items SET title='$this->title', pmenu='$this->pmenu', type='$this->type', iorder='$this->order', pid='$this->pid', url='$this->url', target='$this->target', status='$this->status', securelevel='$this->secureLevel', subMenu='$this->subMenu' WHERE id=$this->id";
			print("<p>".$query."</p>");
			$result = Configuration::Query($query);
			return $result;
		}
		
		public function __toString() {
		    $str = "<div";
		    if ($this->subMenu)
				$str .= " class=\"dropdown\"";
			$str .= "><a href=\"$this->url\" target=\"$this->target\"";
		    if ($this->type == Configuration::$contentType && $this->pid == Configuration::$content->id())
		        $str .= " class=\"current\"";
			$str .= ">$this->title</a>";
			//print_r($this);
			if ($this->subMenu && ($this->pid() != Configuration::$content->id() || $this->type() != Configuration::$contentType)){
			    $str .= $this->subMenu->Dropdown();
			}
			return $str."</div>";
		}
	}

?>
