<?php

class Calculator {
    private $myValue;

    public function setValue($value) {
        $this->myValue = $value;
    }

    public function square() {
        echo "Square: " . ($this->myValue ** 2) . "<br>";
    }

    public function cube() {
        echo "Cube: " . ($this->myValue ** 3) . "<br>";
    }

    // constructor
    public function __construct($initialValue = 0) {
        $this->myValue = $initialValue;
    }
}

// using set function
$cal1 = new Calculator();
$cal1->setValue(5);
echo "<h2>using set and get method</h2> <br>";
$cal1->square(); 
$cal1->cube();


// using constructor
$cal2 = new Calculator(4); 
echo "<h2>using contructor</h2> <br>";
$cal2->square(); 
$cal2->cube(); 

?>

