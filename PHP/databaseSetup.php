<?php

include 'dbConnection.php';
include 'sqlCommands.php';
include "populate.php";

$conn = OpenConnection();
if ($conn) {
    dropTable($conn, "develops");
    dropTable($conn, "supported_devices");
    dropTable($conn, "vr_experience");
    dropTable($conn, "dev_unit");
    dropTable($conn, "avatar");
    dropTable($conn, "free_user");
    dropTable($conn, "paying_user");
    dropTable($conn, "user");

    newTable($conn, "user",
        "userId INT NOT NULL PRIMARY KEY, dob DATE, firstName VARCHAR(255), middleInitial VARCHAR(1), lastName VARCHAR(255), email VARCHAR(255)");
    newTable($conn, "free_user",
        "userId INT NOT NULL, usageQuota INT, FOREIGN KEY (userId) REFERENCES user(userId)");
    newTable($conn, "avatar",
        "userId INT NOT NULL, name VARCHAR(255), species VARCHAR(255), FOREIGN KEY (userId) REFERENCES user(userId)");
    newTable($conn, "paying_user",
        "userId INT NOT NULL, monthlyFee INT, FOREIGN KEY (userId) REFERENCES user(userId)");
    newTable($conn, "dev_unit",
        "unitId INT NOT NULL, unitName VARCHAR(255), unitDesc VARCHAR(255)");
    newTable($conn, "vr_experience",
        "expId INT, name VARCHAR(255), maintainer INT, FOREIGN KEY (maintainer) REFERENCES paying_user(userId)");
    newTable($conn, "supported_devices",
        "expId INT, device VARCHAR(255), FOREIGN KEY (expId) REFERENCES vr_experience(expId)");
    newTable($conn, "develops",
        "userId INT NOT NULL, unitId INT NOT NULL, unitName VARCHAR(255), expId INT, FOREIGN KEY (userId) REFERENCES user(userId), FOREIGN KEY (unitName) REFERENCES dev_unit(unitName), FOREIGN KEY (unitId) REFERENCES dev_unit(unitId), FOREIGN KEY (expId) REFERENCES vr_experience(expId)");

    Populate($conn);
    
    echo "Connected Successfully";
    CloseConnection($conn);
} else {
    echo "Failed to Connect";
}



?>