const fs = require('fs')

var text = "";
fs.readFile('test.txt', (err, data) => {
    if (err) throw err;

    // console.log(data.toString());
		text = data.toString();
		console.log(text);
		console.log("----------------------------");
		// text = text.replace(/[\r\n]*(\[LINE\])[\r\n]*$/, 'HERE');
		var i = text.indexOf("[LINE]");
		var first = (text.substring(0, i)).trim();
		var second = (text.substring(i+6, text.length)).trim();
		second = text.substring(text.indexOf(second), text.length)
		var formatted = first+"<hr>"+second;
		console.log(formatted);
})



// while(text.indexOf("[LINE]")!=-1){
// 	// text = text.replace(.*(/^\s+|\s+$/g)+"[LINE]"+.*, '');
// 	text = text.replace(/\n$/, '');
// 	// text = text.replace("[LINE]", "<hr>");
// }

// console.log(text);
