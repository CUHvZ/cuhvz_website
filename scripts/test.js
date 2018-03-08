function formatData(data){
	// adds <br> tags where there are line breaks
	var formated = "";
	var eachLine = data.split('\n');
	for(var i = 0, l = eachLine.length; i < l; i++) {
	    formated += eachLine[i]+"<br>";
	}

	// formats LINK[name][link] into an html link
	while(formated.indexOf("LINK[")!=-1){
		var start = formated.indexOf("LINK[")
		var link = formated.substring(start,formated.length);
		var link_name = link.substring(5,link.indexOf("]"));
		var temp = "LINK["+link_name+"][";
		start = formated.indexOf(temp)+temp.length;
		link = formated.substring(start,formated.length);
		link = link.substring(0,link.indexOf("]"));
		var to_replace = "LINK[" + link_name + "][" + link + "]";
		formated = formated.replace(to_replace, "<a href='"+link+"'>"+link_name+"</a>");
	}
	return formated;
}

function getData(dataSource, divID) 
{ 
	var XMLHttpRequestObject = false; 

	if (window.XMLHttpRequest) {
		XMLHttpRequestObject = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}

	if(XMLHttpRequestObject) {
		var obj = document.getElementById(divID); 
		XMLHttpRequestObject.open("GET", dataSource); 

		XMLHttpRequestObject.onreadystatechange = function() 
		{ 
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) { 
				var data = XMLHttpRequestObject.responseText;
				obj.innerHTML = formatData(data);
				
			} 
		} 

		XMLHttpRequestObject.send(null); 
	}
}