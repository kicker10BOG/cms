<?
echo $menu_spacer;

echo "<a href=\"".$fullHomDir."\"";
if ($end_of_title == "Home")
{echo " id=\"current\"";}
echo " target=\"_parent\"> Home</a>";

echo $menu_spacer;

echo "<a href=\"".$fullHomDir."register\"";
if ($end_of_title == "Register")
{echo " id=\"current\"";}
echo " target=\"_parent\">Register</a>";

echo $menu_spacer;
?>