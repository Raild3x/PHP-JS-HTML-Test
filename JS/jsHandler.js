

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
    xhttp.open("POST", "../PHP/getArray.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd=tables");
    var div = document.getElementById("tableButtons")
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            div.innerHTML = "";
            console.log(this.response);
            var list = JSON.parse(this.response);
            for(var i = 0; i < list.length; i++){ 
                var tblName = fixString(list[i]);
                div.innerHTML = div.innerHTML + ("<button id='"+list[i]+"' class='tableButton' onclick=openOptions('"+list[i]+"')>"+tblName+"</button>"); 
            } 
        }
    };
}

function openOptions(tblName) {
    console.log("Table Selected: "+tblName);
    document.getElementById("optionLabel").innerHTML = "Select an operation to perform on the <b>"+tblName+"</b> table.";
    document.getElementById("optionButtons").innerHTML = "<button id='newElement' onclick=showOperationInputs('"+tblName+"','new')>New Element</button>"
        +"<button id='selectElement' onclick=showOperationInputs('"+tblName+"','select')>Select Element</button>"
        +"<button id='updateElement' onclick=showOperationInputs('"+tblName+"','update')>Update Element</button>"
        +"<button id='deleteElement' onclick=showOperationInputs('"+tblName+"','delete')>Delete Element</button>";
}

function showOperationInputs(tblName, operation) {
    console.log("Performing operation: "+operation+" on table: "+tblName);
    var fields = document.getElementById("fields")
    fields.innerHTML = ""
    switch(operation) {
        case "new":
            newElement(tblName, fields);
            break;
        case "select":
            break;
        case "update":
            break;
        case "delete":
            break;
    }
}

function newElement(tblName, fields) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../PHP/getArray.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd=columns&tblName="+tblName);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            fields.innerHTML = "Enter the data fields for a new <b>"+tblName+"</b> entry.</br>";
            console.log(this.response);
            var columns = JSON.parse(this.response);
            for (col in columns) {
                col = columns[col];
                col = fixString(col);
                fields.innerHTML = fields.innerHTML + "<label class='fieldLabel'>" + col + ": </label><input type='text' id='"+col+"Field'></br>";
            }
            
        }
    };
}

function fixString(str) {
    str.replace(/([a-z])([A-Z])/g, '$1 $2');
    str = str.charAt(0).toUpperCase() + str.slice(1);
    return str;
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
