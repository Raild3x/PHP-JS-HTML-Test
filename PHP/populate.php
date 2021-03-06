<?php


function randIndex($arr) {
    return $arr[rand(0, count($arr)-1)];
}

function Populate($conn){
    $firstNames = array("Logan", "Taylor", "Liam", "Midge", "David", "Liam", "Michael", "Hailey", "Mophyr", "Solar", "Joe");
    $lastNames = array("Hunt", "Norris", "Smith", "Brosie", "Colby", "Duncan", "Motley", "Avern", "Jonas");
    $emails = array("@earthlink.net", "@gmail.com", "@outlook.com", "@bigfoot.org");
    $avatarNames = array("Ragnarok", "Gimli", "ShadowMan", "xX_Sonic_Xx");
    $speciesList = array("Elf", "Nord", "Imperial", "Orc", "Khajit", "Argonian", "Dunmer");

    //echo "Populating users</br>";
    // Populate users
    for ($i = 0; $i < 500; $i++) {
        $id = rand(1,2147483646);
        $dob = rand(1900,2020)."-0".rand(1,9)."-".rand(0,2).rand(1,8);
        $fN = randIndex($firstNames);
        $mI = chr(rand(65,90));
        $lN = randIndex($lastNames);
        $email = $fN.$lN.rand(1,99).$emails[rand(1,count($emails)-1)];

        newRow($conn, "user", array($id,$dob,$fN,$mI,$lN,$email));
    }

    //echo "Populating free users</br>";
    // Populate free users
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "free_user", array(getRandom($conn, "user", "userId"), rand(50,100)));
    }

    //echo "Populating paying users</br>";
    // Populate paying users
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "paying_user", array(getRandom($conn, "user", "userId"), rand(5,100)));
    }

    //echo "Populating avatars</br>";
    // Populate avatar
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "avatar", array(getRandom($conn, "user", "userId"), randIndex($avatarNames), randIndex($speciesList)));
    }

    //echo "Populating devunit</br>";
    // Populate devUnit
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "dev_unit", array(rand(1,2147483646), "UnitName_Placeholder".rand(0,9999), "UnitDesc_Placeholder".rand(0,9999)));
    }

    //echo "Populating vrExperience</br>";
    // Populate vrExperience
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "vr_experience", array(rand(1,2147483646), "VrName_Placeholder".rand(0,9999), getRandom($conn, "paying_user", "userId")));
    }

    //echo "Populating supportedDevices</br>";
    // Populate supportedDevices
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "supported_devices", array(getRandom($conn, "vr_experience", "expId"), "Device_Placeholder".rand(0,9999)));
    }

    //echo "Populating develops</br>";
    // Populate develops
    for ($i = 0; $i < 100; $i++) {
        newRow($conn, "develops", array(getRandom($conn, "user", "userId"), getRandom($conn, "dev_unit", "unitId"), getRandom($conn, "dev_unit", "unitName"), getRandom($conn, "vr_experience", "expId")));
    }
    

}

?>