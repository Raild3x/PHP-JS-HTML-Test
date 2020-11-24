<?php




function Populate($conn){
    $firstNames = array("Logan", "Taylor", "Liam", "Midge", "David", "Liam", "Michael");
    $lastNames = array("Hunt", "Norris", "Smith", "Brosie", "Colby", "Duncan", "Motley");
    $emails = array("@earthlink.net", "@gmail.com", "@outlook.com", "@bigfoot.org");

    // Populate users
    for ($i = 0; $i < 500; $i++) {
        $id = rand(1,2147483646);
        $dob = rand(1000,2020)."-0".rand(1,9)."-".rand(0,2).rand(1,8);
        $fN = $firstNames[rand(0, count($firstNames)-1)];
        $mI = chr(rand(65,90));
        $lN = $lastNames[rand(0, count($lastNames)-1)];
        $email = $fN.$lN.rand(1,99).$emails[rand(1,count($emails)-1)];

        newRow($conn, "user", array($id,$dob,$fN,$mI,$lN,$email));
    }

    // Populate paying users
    for ($i = 0; $i < 100; $i++) {

    }

}

?>