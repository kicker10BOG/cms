<?php

	// Abstract Content Class
	// Contains common attributes for all types of content
	abstract class Content {
		// Content data
		protected $id;
		protected $title;
		protected $alias;
		protected $description;
		protected $tags;
		protected $template;
		protected $date;
		protected $security;
		protected $status;
		protected $error;
		// Content display options
		protected $showTitle;
		protected $showDescription;
		protected $showTags;
		protected $showDate;

		public function __construct($info) {
		    //echo "<br>$info<br>";
			if (is_array($info)) {
			    //echo "<br>Array - Get Row<br>";
				$this->GetRow($info);}
			elseif (is_int($info)){
			    //echo "<br>int - Get ID<br>";
			    $this->GetByID($info);}
			elseif (is_string($info)){
			    //echo "<br>String - Get Alias<br>";
				$this->GetByAlias($info);}
			else
			    ;//echo "<br>Error!<br>";
		}
		
		public function template() {
			return $this->template;
		}
		public function id(){
			return $this->id;
		}
		public function title(){
			return $this->title;
		}
		public function alias(){
			return $this->alias;
		}
		public function description(){
			return $this->description;
		}
		public function tags(){
			return $this->tags;
		}
		public function date(){
			return date("M d, Y, g:i a", $this->date);
			
		}
		public function error() {
			return $this->error;
		}
		
		abstract protected function Display();
		
		abstract protected function GetByID($id);
		abstract protected function GetByTitle($title);
		abstract protected function GetByAlias($alias);
		abstract protected function GetRow($row);
	}

?>
