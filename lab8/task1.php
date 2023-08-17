<?php

class Rectangle {
    private $width;
    private $height;

    public function setWidth($w) {
        $this->width = $w;
    }

    public function setHeight($h) {
        $this->height = $h;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }
    public function getsetshowArea() {
        $area = $this->getWidth() * $this->getHeight();
        echo "Area: " . $area . "<br>";
    }
    public function showArea() {
        echo "Area: " . ($this->width * $this->height) . "<br>";
    }
    public function __construct($width = 0, $height = 0) {
        $this->width = $width;
        $this->height = $height;
    }
}

$rect1 = new Rectangle();
$rect2 = new Rectangle();

$rect1->setWidth(10);
$rect1->setHeight(5);

$rect2->setWidth(7);
$rect2->setHeight(8);
echo "<h1>using get and set method</h1> <br>";
$rect1->getsetshowArea();
$rect2->getsetshowArea();

// using contructor 
echo "<h1>using contructor</h1> <br>";
$rect3 = new Rectangle(12, 6);
$rect4 = new Rectangle(9, 7);
$rect3->showArea(); 
$rect4->showArea();
?>




