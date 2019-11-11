/*
Valid tags

[SUPPLY_DROPS]
[ON_CAMPUS]
[OFF_CAMPUS]
[LINE]

LINK[]
LINK_NEW_TAB[]
IMAGE[]
IMAGE_SIZE[][]
BOLD[]
INCLUDE[] handled on backend
*/

function formatData(data){
  // adds <br> tags where there are line breaks
  var formatted = "";
  var eachLine = data.split('\n');
  var leadingWhitespace = true;
  for(var i = 0, l = eachLine.length; i < l; i++) {
      if(eachLine[i].length > 0 && leadingWhitespace){
        leadingWhitespace = false;
        formatted = '<div style="white-space: pre-line">';
      }
      if(!leadingWhitespace){
        if(eachLine[i].indexOf("[ON_CAMPUS]") >= 0){
          formatted += "<h5 style='margin: 0'>On Campus</h5>";
        }else if(eachLine[i].indexOf("[OFF_CAMPUS]") >= 0){
          formatted += "<h5 style='margin: 0'>Off Campus</h5>";
        }else if(eachLine[i].indexOf("[SUPPLY_DROPS]") >= 0){
          formatted += "<h5 style='margin: 0'>Supply Drops</h5>";
        }else{
          formatted += eachLine[i] + "\n";
        }
      }
  }

  // formats LINK[name][link] into an html link
  while(formatted.indexOf("LINK[")!=-1){
    var start = formatted.indexOf("LINK[")
    var link = formatted.substring(start,formatted.length);
    var link_name = link.substring(5,link.indexOf("]"));
    var temp = "LINK["+link_name+"][";
    start = formatted.indexOf(temp)+temp.length;
    link = formatted.substring(start,formatted.length);
    link = link.substring(0,link.indexOf("]"));
    var to_replace = "LINK[" + link_name + "][" + link + "]";
    formatted = formatted.replace(to_replace, "<a href='"+link+"'>"+link_name+"</a>");
  }

  // formats LINK_NEW_TAB[name][link] into an html link
  while(formatted.indexOf("LINK_NEW_TAB[")!=-1){
    var start = formatted.indexOf("LINK_NEW_TAB[")
    var link = formatted.substring(start,formatted.length);
    var link_name = link.substring(13,link.indexOf("]"));
    var temp = "LINK_NEW_TAB["+link_name+"][";
    start = formatted.indexOf(temp)+temp.length;
    link = formatted.substring(start,formatted.length);
    link = link.substring(0,link.indexOf("]"));
    var to_replace = "LINK_NEW_TAB[" + link_name + "][" + link + "]";
    formatted = formatted.replace(to_replace, "<a href='"+link+"' target='_blank' >"+link_name+"</a>");
  }

  // formats IMAGE[link] into an image
  while(formatted.indexOf("IMAGE[")!=-1){
    var start = formatted.indexOf("IMAGE[")
    var temp = formatted.substring(start,formatted.length);
    var imageLink = temp.substring(6,temp.indexOf("]"));
    var to_replace = "IMAGE[" + imageLink + "]";
    formatted = formatted.replace(to_replace, "<img src='" + imageLink + "' style='width: 100%;'>");
  }

  // formats IMAGE[link][size %] into an image
  while(formatted.indexOf("IMAGE_SIZE[")!=-1){
    var start = formatted.indexOf("IMAGE_SIZE[");
    var temp = formatted.substring(start,formatted.length);
    var imageLink = temp.substring(11, temp.indexOf("]"));
    var size = temp.substring(11 + imageLink.length + 2, temp.indexOf("]"));
    var to_replace = "IMAGE_SIZE[" + imageLink + "]";
    formatted = formatted.replace(to_replace, "<img src='" + imageLink + "' style='width: " + size + "%;'>");
  }

  // formats BOLD[content] into an strong tag
  while(formatted.indexOf("BOLD[")!=-1){
    var start = formatted.indexOf("BOLD[")
    var temp = formatted.substring(start,formatted.length);
    var content = temp.substring(5,temp.indexOf("]"));
    var to_replace = "BOLD[" + content + "]";
    formatted = formatted.replace(to_replace, "<strong>"+content+"</strong>");
  }

  // formats [LINE] into line break
  while(formatted.indexOf("[LINE]")!=-1){
    var i = formatted.indexOf("[LINE]");
    var first = (formatted.substring(0, i)).trim();
    var second = (formatted.substring(i+6, formatted.length)).trim();
    second = formatted.substring(formatted.indexOf(second), formatted.length)
    var formatted = first+"<hr>"+second;
  }

  formatted += "</div>";
  return formatted;
}
