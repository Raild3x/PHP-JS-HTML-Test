

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
    let query = document.getElementById("query").value
    alert("Query was " + query);
    document.getElementById("response").innerHTML  = query + " thingy.";
}