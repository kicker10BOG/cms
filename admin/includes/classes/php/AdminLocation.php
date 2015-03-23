<?php

	// Admin Location Class
	class AdminLocation extends Location {
		// inherits data and generic functions from Location

		public function __construct($id) {
			$query = "SELECT * FROM ".Configuration::sitePrefix."adminLocations WHERE id=$id";
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
						case "menu": $query .= "adminMenus"; break;
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
							case "menu": $this->items[] = new AdminMenu($rows[$i]); break;
						}
						$i += 1;
					}
				}
			}
		}
	}

?>
