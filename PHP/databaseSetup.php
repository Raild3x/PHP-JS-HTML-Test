<?php

include 'dbConnection.php';
include 'sqlCommands.php';
include "populate.php";

$conn = OpenConnection();
if ($conn) {
    dropTable($conn, "develops");
    dropTable($conn, "supportedDevices");
    dropTable($conn, "vrExperience");
    dropTable($conn, "devUnit");
    dropTable($conn, "avatar");
    dropTable($conn, "freeUser");
    dropTable($conn, "payingUser");
    dropTable($conn, "user");

    newTable($conn, "user",
        "userId INT NOT NULL PRIMARY KEY, dob DATE, firstName VARCHAR(255), middleInitial VARCHAR(1), lastName VARCHAR(255), email VARCHAR(255)");
    newTable($conn, "freeUser",
        "userId INT NOT NULL, usageQuota INT, FOREIGN KEY (userId) REFERENCES user(userId)");
    newTable($conn, "avatar",
        "userId INT NOT NULL, name VARCHAR(255), species VARCHAR(255), FOREIGN KEY (userId) REFERENCES user(userId)");
    newTable($conn, "payingUser",
        "userId INT NOT NULL, monthlyFee INT, FOREIGN KEY (userId) REFERENCES user(userId)");
    newTable($conn, "devUnit",
        "unitId INT NOT NULL, unitName VARCHAR(255), unitDesc VARCHAR(255)");
    newTable($conn, "vrExperience",
        "expId INT, name VARCHAR(255), maintainer INT, FOREIGN KEY (maintainer) REFERENCES payingUser(userId)");
    newTable($conn, "supportedDevices",
        "expId INT, device VARCHAR(255), FOREIGN KEY (expId) REFERENCES vrExperience(expId)");
    newTable($conn, "develops",
        "userId INT NOT NULL, unitId INT NOT NULL, unitName VARCHAR(255), expId INT, FOREIGN KEY (userId) REFERENCES user(userId), FOREIGN KEY (unitName) REFERENCES devUnit(unitName), FOREIGN KEY (unitId) REFERENCES devUnit(unitId), FOREIGN KEY (expId) REFERENCES vrExperience(expId)");

    Populate($conn);
    
    echo "Connected Successfully";
    CloseConnection($conn);
} else {
    echo "Failed to Connect";
}



?>