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
    document.getElementById("optionLabel").innerHTML = "Select an operation to perform on the <b>"+fixString(currentTable)+"</b> table.";
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
            updateElement(fields);
            break;
        case "delete":
            break;
    }
}

function updateElement(fields) {
    fields.innerHTML = "Choose what elements to update.";
    fields.innerHTML += "<label class='fieldLabel'>(colName=newVal)   New Column Values:</label><input type='text' id='columnsField'></br>";
    fields.innerHTML += "<label class='fieldLabel'>Condition:</label><input type='text' id='conditionField'></br>";
    activeFieldIds.push("columnsField");
    activeFieldIds.push("conditionField");
}

function selectElement(fields) {
    fields.innerHTML = "Specify your arguments for selection. Separate <u>Columns and Tables</u> with commas and <u>Conditions</u> with <b>AND</b> or <b>OR</b></br>";
    fields.innerHTML += "<label class='fieldLabel'>Accessible Tables:</label><input type='text' id='tableField'></br>";
    fields.innerHTML += "<label class='fieldLabel'>Columns:</label><input type='text' id='columnsField'></br>";
    fields.innerHTML += "<label class='fieldLabel'>Condition:</label><input type='text' id='conditionField'></br>";
    document.getElementById("columnsField").defaultValue = "*";
    document.getElementById("tableField").defaultValue = currentTable;
    activeFieldIds.push("tableField");
    activeFieldIds.push("columnsField");
    activeFieldIds.push("conditionField");
    
}


function newElement(fields) {
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../PHP/getArray.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd=columns&tblName="+currentTable);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            fields.innerHTML = "Enter the data fields for a new <b>"+fixString(currentTable)+"</b> entry.</br>";
            console.log(this.response);
            let columns = JSON.parse(this.response);
            for (let fieldName in columns) {
                let dataType = columns[fieldName];
                let fieldType = getFieldType(dataType, fieldName);
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
    str = str.replace("_", " ");
    str = str.replace(/(^\w{1})|(\s+\w{1})/g, letter => letter.toUpperCase());
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
    for (let i in activeFieldIds) {
        var id = activeFieldIds[i];
        //console.log(id);
        var data = document.getElementById(id).value.trim();
        if (data == "") {
            data = document.getElementById(id).defaultValue;
        }
        if (data != "") {
            values += data+"|";
        }
        /*if (data.search(" ") != -1) {
            response.innerHTML = "Response: Invalid space detected in "+id+".";
            return;
        }*/
    }
    values = values.slice(0,-1);
    console.log("cmd="+currentOperation+"&tblName="+currentTable+"&values="+values);

    var xhttp = new XMLHttpRequest();
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/query.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cmd="+currentOperation+"&tblName="+currentTable+"&values="+values);

    document.getElementById("response").innerHTML = "Response: waiting for response...";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = "Response:<hr>" +  this.response;
        } else {
            document.getElementById("response").innerHTML = "Failed to read response: " + this.response + "\t"+this.readyState+":"+this.status;
        }
    };
}