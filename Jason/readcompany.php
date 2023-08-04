<?php
$jsondata = file_get_contents("company.json");

$comanyData = json_decode($jsondata, true);

//Reading companis
foreach($comanyData['company']['employees'] as $com){
    echo "Title: " . $com['firstName'] . "<br>";
}
echo "<br>";

//reading bosses
foreach($comanyData['bosses']['worker'] as $com){
    echo "Title: " . $com['firstName'] . "<br>";
}
echo "<br>";


?>