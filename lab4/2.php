<?php
$rows = 5;
$star = 0;

// First pattern
for ($i = 0; $i < $rows; $i++) {
    // Printing spaces
    for ($j = 0; $j < $i; $j++) {
        echo " ";
    }
    // Printing stars
    for ($j = 0; $j < 2 * ($rows - $i) - 1; $j++) {
        echo "*";
    }
    echo "\n";
}

// Second pattern
for ($i = $rows - 2; $i >= 0; $i--) {
    // Printing spaces
    for ($j = 0; $j < $i; $j++) {
        echo " ";
    }
    // Printing stars
    for ($j = 0; $j < 2 * ($rows - $i) - 1; $j++) {
        echo "*";
    }
    echo "\n";
}
?>
