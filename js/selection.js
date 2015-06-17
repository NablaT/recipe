function include(fileName){
document.write("<script type='text/javascript' src='"+fileName+"'></script>" );
}

function request(callback) {
    var xhr = getXMLHttpRequest();
    var confirmation = "",
		selected = document.querySelectorAll(".selected");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };
	
	for(var i=0, l=selected.length; i<l; i++) confirmation += "" + selected[i].children[0].innerHTML +"/";
	
	l == 0 && (confirmation = "Vous n'avez rien choisi :(");
    
    xhr.open("GET", "../recipescreen/index.php?list=" + confirmation, true);
    xhr.send(null);
}
function readData(sData) {
    alert(sData);
	location.reload();
}

function clicked(){
	this.className = /selected/.test(this.className) ? this.className.replace(" selected", "") : this.className+" selected";
}

function valider(e){
	request(readData);
	/*var confirmation = "",
		selected = document.querySelectorAll(".selected");
	
	for(var i=0, l=selected.length; i<l; i++) confirmation += "" + selected[i].children[0].innerHTML +"/" + selected[i].children[1].innerHTML + "\n";
	
	l == 0 && (confirmation = "Vous n'avez rien choisi :(");
	
	 var xhr = getXMLHttpRequest();
    
   /* xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };
    
    xhr.open("GET", "add_after_delete.php?list=" + confirmation, true);
    xhr.send(null);
	//alert(confirmation*/
}

include('oXHR.js');
var tr = document.querySelectorAll("#table tr"),
	a = document.querySelector("a");

for (var i=0, l=tr.length ; i<l; i++) tr[i].addEventListener("click", clicked, false);

a.addEventListener("click", valider, false);
