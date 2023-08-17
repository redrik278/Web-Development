<?php

class Student {
    private $name;
    private $id;
    private $CGPA;

    public function __construct($name, $id, $CGPA) {
        $this->name = $name;
        $this->id = $id;
        $this->CGPA = $CGPA;
    }

    public function getCGPA() {
        return $this->CGPA;
    }
}
$std1 = new Student("Arafat", "094", 3.0);
$std2 = new Student("Afridi", "241", 2.25);

$avgCGPA = ($std1->getCGPA() + $std2->getCGPA()) / 2;

echo "Average CGPA: " . $avgCGPA."<br>";
?>
