<?php
echo "
html {
margin:             0;
height:             100%;
padding:            0;
}

body {
position:           absolute;
margin:             0;
padding:            0;
height:             100%;
width:              100%;
min-width:          600px;
margin:             0;
background:         url(".$image_dir."banners/bg.png) repeat-x 0px 100px rgb(32, 95, 196);
font-family:        \"Times New Roman\", \"Verdana\",	\"Helvetica\", \"Arial\";
}

#container
{
position:           absolute;
background:         url(".$banner_bg.") repeat-x transparent;
margin:             0;
padding:            0;
height:             100%;
width:              100%;
}

#container2
{
position:           absolute;
margin:             0;
padding:            0;
background:         #FFFFFF;
min-height:         100%;
left:               5%;
width:              90%;
}

#banner
{
position:           relative;
background:         url(".$banner_bg.") repeat-x rgb(32, 95, 196);
width:              106%;
margin:             0;
margin-left:        -6%;
padding:            0;
text-align:         left;
height:             100px;
}
#banner img, #banner a
{
border:             0;
margin:             0;
padding:            0;
}
#banner a
{
width:              100%;
}

#mainsection
{
position:           relative;
background:         #FFFFFF;
color:              #000000;
}

#maincontent
{
position:           relative;
display:            block;
padding-left:       15px;
padding-right:      15px;
padding-top:        5px;
padding-bottom:     5px;
top:                0;
bottom:             50px;
width:              90%;
background:         #FFFFFF;
color:              #000000;
}

#footspacer
{
position:           relative;
width:              100%;
height:             45px;
line-height:        45px;
text-align:         center;
vertical-align:     middle;
font-size:          15px;
color:              #FFFFFF;
padding-top:        5px;
}
#foot
{
position:           absolute;
bottom:             0;
width:              100%;
height:             45px;
line-height:        45px;
background:         url(".$image_dir."menu/tmenu.png) repeat center transparent;
text-align:         center;
vertical-align:     middle;
font-size:          15px;
color:              #FFFFFF;
padding-top:        5px;
}

#foot a
{
font-size:          15px;
color:              #FFFFFF;
}

.cent 
{
text-align:         center;
vertical-align:     middle;
}

marquee 
{
font-size:          25px;
width:              100%;
}

hr 
{
height:             5px;
width:              80%;
}

h1,h2,h3,h4,h5,h6 
{
text-align:         center;
}
";
?>
