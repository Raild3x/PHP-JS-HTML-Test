

function loadPage() {
    var xhttp = new XMLHttpRequest();
    
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/databaseSetup.php", true);
    xhttp.send();
    
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("isLoaded").innerHTML = "Database: " +  this.response;
            setupHtml();
        } else {
            document.getElementById("isLoaded").innerHTML = "Database: " +  "Failed to Connect";
        }
    };
}

function setupHtml() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../PHP/getTables.php", true);
    xhttp.send();
    var div = document.getElementById("tableButtons")
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            div.innerHTML = "";
            var list = JSON.parse(this.response);
            console.log(this.response);
            for(var i = 0; i < list.length; i++){ 
                div.innerHTML = div.innerHTML + ("<button id='"+list[i]+"' class='tableButton' onclick=openOptions('"+list[i]+"')>"+list[i]+"</button>"); 
            } 
        }
    };
}

function openOptions(tblName) {
    console.log("Table Selected: "+tblName);
    document.getElementById("optionLabel").innerHTML = "Select an operation to perform on the <b>"+tblName+"</b> table.";
    document.getElementById("optionButtons").innerHTML = "<button id='newElement' onclick=showOperationInputs('"+tblName+"', 'new')>New Element</button>"
        +"<button id='selectElement' onclick=showOperationInputs(\""+tblName+"\", \"select\")>Select Element</button>"
        +"<button id='updateElement' onclick=showOperationInputs('"+tblName+"', 'update')>Update Element</button>"
        +"<button id='deleteElement' onclick=showOperationInputs('"+tblName+"', 'delete')>Delete Element</button>";
}

function showOperationInputs(tblName, operation) {
    console.log("Performing operation: "+operation+" on table: "+tblName);
}


function submitQuery() {
    // The boxes are currently disabled in favor of this so I dont have to constantly retype the info
    const cmd = "new row"; //document.getElementById("cmd").value.toLowerCase();
    const tblName = "user"; //document.getElementById("tblName").value
    const values = "12345 1997-12-29 David L Hunt 2dloganh@gmail.com"; //document.getElementById("values").value

    var xhttp = new XMLHttpRequest();
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/query.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd="+cmd+"&tblName="+tblName+"&values="+values);

    document.getElementById("response").innerHTML = "Response: waiting for response...";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = "Response: " +  this.response;
        } else {
            document.getElementById("response").innerHTML = "Failed to read response: " + this.response + "\t"+this.readyState+":"+this.status;
        }
    };
}
