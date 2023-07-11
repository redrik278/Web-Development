<?php
function changeCase($array, $toUpper = true)
{
    $result = array();

    foreach ($array as $key => $value) {
        if ($toUpper) {
            $convertedValue = convertToUpper($value);
        } else {
            $convertedValue = convertToLower($value);
        }
        $result[$key] = $convertedValue;
    }

    return $result;
}

function convertToUpper($value)
{
    $upperValue = '';
    $length = strlen($value);

    for ($i = 0; $i < $length; $i++) {
        $char = $value[$i];

        if (ctype_lower($char)) {
            $upperValue .= chr(ord($char) - 32);
        } else {
            $upperValue .= $char;
        }
    }

    return $upperValue;
}

function convertToLower($value)
{
    $lowerValue = '';
    $length = strlen($value);

    for ($i = 0; $i < $length; $i++) {
        $char = $value[$i];

        if (ctype_upper($char)) {
            $lowerValue .= chr(ord($char) + 32);
        } else {
            $lowerValue .= $char;
        }
    }

    return $lowerValue;
}

$Color = array('A' => 'Blue', 'B' => 'Green', 'c' => 'Red');

// Change values to lower case
$lowerCaseColor = changeCase($Color, false);
echo "Values are in lower case.\n";
print_r($lowerCaseColor);

// Change values to upper case
$upperCaseColor = changeCase($Color, true);
echo "Values are in upper case.\n";
print_r($upperCaseColor);
?>
