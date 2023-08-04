<?php
$xml = simplexml_load_file("books.xml") or die("Error : Cannot create Object");
echo $xml->book[0]->title."<br>";
echo $xml->book[2]->title;
?>