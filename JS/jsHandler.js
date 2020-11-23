// GLOBALS

var activeFieldIds = [];
var currentOperation = null;
var currentTable = null;


// FUNCTIONS

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
                div.innerHTML += ("<button id='"+list[i]+"' class='tableButton' onclick=openOptions('"+list[i]+"')>"+tblName+"</button>"); 
            } 
        }
    };
}

function openOptions(clickedTable) {
    currentTable = clickedTable
    console.log("Table Selected: "+currentTable);
    currentOperation = null;
    document.getElementById("fields").innerHTML = "";
    document.getElementById("optionLabel").innerHTML = "Select an operation to perform on the <b>"+currentTable+"</b> table.";
    document.getElementById("optionButtons").innerHTML = "<button id='newElement' onclick=showOperationInputs('new')>New Element</button>"
        +"<button id='selectElement' onclick=showOperationInputs('select')>Select Element</button>"
        +"<button id='updateElement' onclick=showOperationInputs('update')>Update Element</button>"
        +"<button id='deleteElement' onclick=showOperationInputs('delete')>Delete Element</button>";
}

function showOperationInputs(operation) {
    console.log("Performing operation: "+operation+" on table: "+currentTable);
    activeFieldIds = [];
    currentOperation = operation;
    var fields = document.getElementById("fields")
    fields.innerHTML = ""
    switch(operation) {
        case "new":
            newElement(fields);
            break;
        case "select":
            selectElement(fields);
            break;
        case "update":
            break;
        case "delete":
            break;
    }
}

function selectElement(fields) {
    //fields.innerHTML = "<label class='fieldLabel'>: </label><input type='text' id='"+fieldName+"Field' value="+getDefaultValue(fieldType, fieldName)+"></br>";
}


function newElement(fields) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../PHP/getArray.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd=columns&tblName="+currentTable);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            fields.innerHTML = "Enter the data fields for a new <b>"+currentTable+"</b> entry.</br>";
            console.log(this.response);
            var columns = JSON.parse(this.response);
            for (fieldName in columns) {
                var dataType = columns[fieldName];
                fieldType = getFieldType(dataType, fieldName);
                fields.innerHTML += "<label class='fieldLabel'>" + fixString(fieldName) + ": </label><input type='"+fieldType+"' id='"+fieldName+"Field' value="+getDefaultValue(fieldType, fieldName)+"></br>";
                activeFieldIds.push(fieldName+"Field");
            }
            
        }
    };
}

function getFieldType(dataType, fieldName) {
    if (dataType.search("varchar") != -1) {
        if (fieldName.search("email") != -1) {
            return "email";
        } else {
            return "text";
        }
    } else if (dataType.search("int") != -1) {
        return "number";
    } else if (dataType.search("date") != -1) {
        return "date";
    }
    return "text";
}

function getDefaultValue(fieldType, fieldName) {
    if (fieldName.search("Id") != -1) {
        return Math.floor(Math.random()*2147483647);
    }
    if (fieldType == "date") {
        return "2000-01-01";
    }
    return "";
}

function fixString(str) {
    str = str.replace(/([a-z])([A-Z])/g, '$1 $2');
    str = str.charAt(0).toUpperCase() + str.slice(1);
    return str;
}

function submitQuery() {
    //collect fields
    var response = document.getElementById("response")
    if (currentTable == null) {
        response.innerHTML = "Response: No table yet selected to operate on.";
        return;
    }
    if (currentOperation == null) {
        response.innerHTML = "Response: No Operation Selected to perform.";
        return;
    }
    

    var values = "";
    for (i in activeFieldIds) {
        var id = activeFieldIds[i];
        var data = document.getElementById(id).value
        values += data+",";
        if (data.search(" ") != -1) {
            response.innerHTML = "Response: Invalid space detected in "+id+".";
            return;
        }
    }
    values = values.slice(0,-1);
    console.log(values);

    var xhttp = new XMLHttpRequest();
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/query.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd="+currentOperation+"&tblName="+currentTable+"&values="+values);

    document.getElementById("response").innerHTML = "Response: waiting for response...";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = "!Response: " +  this.response;
        } else {
            document.getElementById("response").innerHTML = "Failed to read response: " + this.response + "\t"+this.readyState+":"+this.status;
        }
    };
}

function oldsubmitQuery() {
    // The boxes are currently disabled in favor of this so I dont have to constantly retype the info
    const cmd = "new row"; //document.getElementById("cmd").value.toLowerCase();
    const currentTable = "user"; //document.getElementById("currentTable").value
    const values = "12345 1997-12-29 David L Hunt 2dloganh@gmail.com"; //document.getElementById("values").value

    var xhttp = new XMLHttpRequest();
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/query.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd="+cmd+"&tblName="+currentTable+"&values="+values);

    document.getElementById("response").innerHTML = "Response: waiting for response...";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = "Response: " +  this.response;
        } else {
            document.getElementById("response").innerHTML = "Failed to read response: " + this.response + "\t"+this.readyState+":"+this.status;
        }
    };
}
