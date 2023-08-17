<?php

class Circle {
    private $radius;
    private static $PI = 3.1416;

    public function setRadius($radius) {
        $this->radius = $radius;
    }

    public function outputCircumference() {
        $circumference = 2 * self::$PI * $this->radius;
        echo "Circumference: " . $circumference . "<br>";
    }

    public function outputArea() {
        $area = self::$PI * $this->radius ** 2;
        echo "Area: " . $area . "<br>";
    }

    public function __construct($radius=0) {
        $this->radius = $radius;
    }
}
$circle1 = new Circle();

$circle1->setRadius(6);
// using set methond
echo "set radious<br>";
$circle1->outputCircumference(); 
$circle1->outputArea();


$circle2 = new Circle(12);
echo "set radious<br>";
$circle2->outputCircumference(); 
$circle2->outputArea();
?>
