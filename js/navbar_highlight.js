// Highlights the correct navbar item for the current page
$(document).ready(function(){
	try {
		var pathname = $(location).attr('pathname');
		var page = "#"+pathname.substring(1, pathname.length-4)+"_button";
		$(page).attr("class", "active");
	}
	catch(err) {
	    //document.getElementById("demo").innerHTML = err.message;
	}
})