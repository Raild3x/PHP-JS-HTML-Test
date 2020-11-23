

function loadPage() {
    var xhttp = new XMLHttpRequest();
    
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/databaseSetup.php", true);
    xhttp.send();
    
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("isLoaded").innerHTML = "Database: " +  this.response;
            //alert("READY!");
        } else {
            document.getElementById("isLoaded").innerHTML = "Database: " +  "Failed to Connect";
            //alert("Something went wrong. ReadyState: " + this.readyState + ", Status: " + this.status);
        }
    };
}


function submitQuery() {
    const cmd = "new row"; //document.getElementById("cmd").value.toLowerCase();
    const tblName = "user"; //document.getElementById("tblName").value
    const values = "12345"; //document.getElementById("values").value

    var xhttp = new XMLHttpRequest();
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Send PHP request as (post/get, file location, async option)
    xhttp.open("POST", "../PHP/query.php", true);
    
    document.getElementById("response").innerHTML = "Response: waiting for response...";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = "Response: " +  this.response;
            //alert("READY!");
        } else {
            document.getElementById("response").innerHTML = "Failed to read response: " + this.response + "\t"+this.readyState+":"+this.status;
            //alert("Something went wrong. ReadyState: " + this.readyState + ", Status: " + this.status);
        }
    };

    xhttp.send("cmd="+cmd+"&tblName="+tblName+"&values="+values);

    //let query = document.getElementById("query").value
    //alert("Query was " + query);
    //document.getElementById("response").innerHTML  = query + " thingy.";
}
