<?php
function bubbleSort($arr)
{
    $n = count($arr);

    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] < $arr[$j + 1]) {
                // Swap elements
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }

    return $arr;
}

// Input list
$list = [11, 15, 22, 72, 21, 81];

// Sort list in descending order using Bubble sort
$sortedList = bubbleSort($list);

// Display sorted list
echo "Sorted list in descending order:\n";
foreach ($sortedList as $element) {
    echo $element . " ";
}
?>
