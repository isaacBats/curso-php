<?php

class Person 
{

    protected $name;

    private $lastName;

    private $years;


    function __construct( $name ) {
        $this->name = $name;
    }

    public function presentation () {
        $string = "Hi my name is {$this->name} {$this->lastName}";

        if ( !empty($this->years) ) {
            $string .= " and I " . $this->years ." years old.";
        }
        return $string;
    }

    public function getName () {
        return $this->name;
    }

    public function setLastName( $lastName ) {
        $this->lastName = $lastName;
    }

    public function getLastName () {
        return $this->lastName;
    }

    public function setYears( $years ) {
        $this->years = (int) $years;
    }

    public function getYears() {
        return $this->years;
    }

}