<?php 



require_once 'Person.php';
require_once 'InterfaceSportsPerson.php';

// use \App\Person;
// use \App\InterfaceSportsPerson;

class Playsoccer extends Person implements InterfaceSportsPerson
{

    private $position;

    private $number;

    function __construct ( $name, $number ) {
        parent::__construct($name);

        $this->number = (int) $number;

    }

    public function getName() {
        return "Player: {$this->name} {$this->getLastName()}";
    }

    public function personalSport () {

        return 'Soccer';
    }

    public function setPosition ($position) {
        $this->position = $position;
    }

    public function position() {
        return $this->position;
    }

    public function favoriteNumber() {
        return $this->number;
    }
}