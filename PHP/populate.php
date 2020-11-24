<?php




function Populate($conn){
    $firstNames = array("Logan", "Taylor", "Liam", "Midge", "David", "Liam", "Michael");
    $lastNames = array("Hunt", "Norris", "Smith", "Brosie", "Colby", "Duncan", "Motley");
    $emails = array("@earthlink.net", "@gmail.com", "@outlook.com", "@bigfoot.org");

    // Populate users
    for ($i = 0; $i < 500; $i++) {
        $id = rand();
        $dob = rand(1,2020)."-".rand(1,12)."-".rand(1,29);
        $fN = $firstNames[rand(0, count($firstNames)-1)];
        $mI = chr(rand(65,92));
        $lN = $lastNames[rand(0, count($lastNames)-1)];
        $email = $fN.$lN.rand(1,99).$emails[rand(1,count($emails)-1)];

        newRow($conn, "user", array($id,$dob,$fN,$mI,$lN,$email));
    }

    // Populate paying users
    for ($i = 0; $i < 100; $i++) {

    }

}

?>