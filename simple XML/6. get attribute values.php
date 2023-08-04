<?php
$xml = simplexml_load_file("books.xml") or die("Error: cannot create object");
echo $xml->book[0]['category']."<br>";
echo $xml->book[2]->title['lang']."<br>";
echo $xml->book[2]->title;
?>