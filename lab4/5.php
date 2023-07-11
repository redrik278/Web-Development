<?php
function displayPattern()
{
    $pattern = '';
    $limit = 10;

    for ($i = 1; $i <= $limit; $i++) {
        if ($i > 1) {
            if ($i % 3 == 1) {
                $pattern .= '_';
            } elseif ($i % 3 == 2) {
                $pattern .= '#';
            } else {
                $pattern .= '-';
            }
        }

        $pattern .= $i;
    }

    echo $pattern;
}

// Call the function to display the pattern
displayPattern();
?>
