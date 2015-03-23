function GetUrlVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

	for(var i = 0; i < hashes.length; i++)
	{
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = decodeURI(hash[1]);
		//document.write(hash);
	}
	//document.write(vars["Msg"]);
	return vars;
}
var URLvars = GetUrlVars();

function LoadXMLDoc(url, post, postData, asynch, cfunc) {
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		//document.write("test1");
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		//document.write("test2");
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = cfunc;
	xmlhttp.open("POST",url, asynch);
	if (post)
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(postData);
  }
  
function GetContent(page, element){
	LoadXMLDoc(page, false, "", true, function()
			{
				//DispError("test3", 1);
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
				//DispError("test4", 1);
				document.getElementById(element).innerHTML = xmlhttp.responseText;
				}
			});
}

function keyUpAction(e) {
	//DispError(" keyUp " + e.keyCode);
	if(e.keyCode == 13){
		//document.getElementById("p-spin").innerHTML += " [ENTER]";
		document.getElementById("checkLogin").click();
	}
	else  {
		//DispError(" keyUp " + e.keyCode);
		CheckEmail();
	}
}

function DispError (msg, refresh) {
	refresh = refresh || 2;
	if (msg == "" && refresh == 2)
		document.getElementById("error").innerHTML = "";
	else if (msg == "")
		return;
	else if (refresh == 2 || !(document.getElementById("error").innerHTML.trim()))
		document.getElementById("error").innerHTML = "Error: " + msg;
	else
		document.getElementById("error").innerHTML += "<br>Error: " + msg;
}