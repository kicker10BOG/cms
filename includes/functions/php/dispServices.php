<?php
$query2 = "SELECT id, sername FROM services ORDER BY 'id' ASC";
$result2 = mysql_query($query2);
$color = array("#AAAAAA", "#CCCCCC");
if (!$result2 || mysql_num_rows($result2) == 0)
  echo "Unable to load services.";
else {
  $i = 0;
  echo "<p style=\"text-align: center;\"><table style=\"margin-left:auto; margin-right:auto; width: 300px;\" ><tr><td style=\"text-align: right;\">Service Code</td><td>Service Name</td></tr>";
  while ($row = mysql_fetch_assoc($result2)) {
    printf( "<tr style=\"background:%s; text-align: right;\"><td>%06d</td><td style=\"text-align: left;\">%s</td></tr>", $color[$i], $row['id'], $row['sername']);
    $i = ($i + 1) % 2;
  }
  echo "</table></p>";
}?>