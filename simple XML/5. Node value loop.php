<?php
$xml = simplexml_load_file("books.xml") or die("Error : Cannot create Object");
foreach($xml->children() as $books){
    echo $books->title."<br>";
    echo $books->author."<br>";
    echo $books->year."<br>";
    echo $books->price."<br><br>";
}

?>