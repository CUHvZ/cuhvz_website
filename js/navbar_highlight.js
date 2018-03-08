// Highlights the correct navbar item for the current page
function highlight(){
	try {
		var pathname = $(location).attr('pathname');
		var page = pathname.substring(1, pathname.length-4);
		var id = "#"+page+"_button";
		var buttons = ["kys","logkill","logout","profile","admin","login","signup"];
		//var screenWidth = window.matchMedia( "(max-width: 480px)" );
		try{
			$(id).attr("style", "background-color: #EA7B00; color: #FFF;");
			$(id + "_dropdown").attr("style", "background-color: #EA7B00; color: #FFF;");
		}catch(e){}
		if(buttons.indexOf(page) != -1){
			$(id).attr("style", "background-color: #EA7B00; color: #FFF; float: right;");
		}
		var event_subpages = ["weeklong/info","weeklong/stats"];
		if(event_subpages.indexOf(page) != -1){
			$("#events_button").attr("style", "background-color: #EA7B00; color: #FFF;");
			$("#events_button_dropdown").attr("style", "background-color: #EA7B00; color: #FFF;");
		}
	}
	catch(err) {
	    //document.getElementById("demo").innerHTML = err.message;
	}
}
$(document).ready(function(){
	highlight();
})