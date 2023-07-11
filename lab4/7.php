<?php
function removeSpecialCharacters($string)
{
    $specialCharacters = '/[!@#$%^&*\-_=+\\<>\?\/]/';
    $string = preg_replace($specialCharacters, '', $string);
    return $string;
}

// Sample string
$string = 'Hello!@#$ World-*';

// Remove special characters
$cleanString = removeSpecialCharacters($string);

// Display the cleaned string
echo "Original string: $string\n";
echo "Cleaned string: $cleanString";
?>
