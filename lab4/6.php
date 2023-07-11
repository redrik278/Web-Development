<?php
$string = 'The quick brown [dog].';
// Extract text within parentheses
preg_match('/\[(.*?)\]/', $string, $matches);

if (isset($matches[1])) {
    $extractedText = $matches[1];
    echo $extractedText;
} else {
    echo "Nothing text found.";
}
?>