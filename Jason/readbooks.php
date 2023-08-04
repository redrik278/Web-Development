<?php
// Read the JSON data from the file
$jsonData = file_get_contents('books.json');

// Decode the JSON data into a PHP associative array
$bookstoreData = json_decode($jsonData, True);

// Accessing book data
foreach ($bookstoreData['bookstore']['books'] as $book) {
    echo "Title: " . $book['title'] . "<br>";
    echo "Author: " . $book['author'] . "<br>";
    echo "Category: " . $book['category'] . "<br>";
    echo "Year: " . $book['year'] . "<br>";
    echo "Price: $" . $book['price'] . "<br>";
    echo "Languages: " . implode(', ', $book['languages']) . "<br><br>";
}
?>
