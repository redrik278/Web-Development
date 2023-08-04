<?php


function jaccard_similarity($setA, $setB) {
    $intersection = array_intersect($setA, $setB);
    $union = array_merge($setA, $setB);
    $similarity = count($intersection) / count($union);
    return $similarity;
}

function tokenize($text) {
    $words = preg_split('/\s+/', $text);
    return array_unique($words);
}



$file1 = 'file1.txt';
$file2 = 'file2.txt';

$content1 = file_get_contents($file1);
$content2 = file_get_contents($file2);


$words1 = tokenize(strtolower($content1));
$words2 = tokenize(strtolower($content2));


$similarity = jaccard_similarity($words1, $words2);

echo "File 1 Content: <br>";
echo $content1;// Use nl2br to preserve line breaks in the output

echo "<br><br>File 2 Content: <br>";
echo $content2;

echo "<br><br>Jaccard Similarity: " . number_format($similarity * 100, 2) . "%";

?>
