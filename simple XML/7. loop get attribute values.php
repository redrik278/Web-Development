<?php
$xml = simplexml_load_file("books.xml") or die("Error: cannot create object");

foreach($xml->children() as $books){
    echo $books->title['lang'];
    echo "<br>";
}

echo "<br><br>";


//for book category
foreach ($xml->book as $book) {
    echo $book['category']; // Accessing the "category" attribute
    echo "<br>";
}


?>
