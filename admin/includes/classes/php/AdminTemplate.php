<?php

	// Admin Template Class
	class AdminTemplate extends Template {
		// Inherits data from Template

		public function __construct($id) {
			if ($id) {
			    if ($id == "default")
			        $query = "SELECT * FROM ".Configuration::sitePrefix."adminTemplates WHERE isDefault=1";
				else
					$query = "SELECT * FROM ".Configuration::sitePrefix."adminTemplates WHERE id=$id";
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
	}

?>
