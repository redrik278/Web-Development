<?php

class Box {
    private $length;
    private $width;
    private $height;

    public function __construct($length, $width, $height) {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public function getArea() {
        return 2 * ($this->length * $this->width + 
                    $this->length * $this->height + 
                    $this->width * $this->height);
    }
}



$b1 = new Box(10, 10, 10);
echo "Area of the box is :" . $b1->getArea();

?>
