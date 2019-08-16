<?php

namespace App\Models;

require_once 'Printable.php';

use App\Models\Printable;
/**
 * Short description for Job.php
 *
 * @package Job
 * @author daniel <daniel@daniel-lap-dell-l3560>
 * @version 0.1
 * @copyright (C) 2019 daniel <daniel@daniel-lap-dell-l3560>
 * @license MIT
 */
Class BaseElement implements Printable {
    
    protected $title;
    protected $description;
    public $visible;
    public $months;


    public function __construct ($title, $description) {
        $this->setTitle($title);
        $this->description = $description;
    }

    public function getTitle() 
    {
        return $this->title;
    }

    public function setTitle($title) 
    {
        if ($title == '') {
            $this->title = 'N/A';
        } else {
            $this->title = $title;
        }
    }

    public function getDurationAsString()
    {
        $years = floor( $this->months / 12 );
        $extraMonths = $this->months % 12;

        return "{$years} years {$extraMonths} monts";
    }

    public function getDescription()
    {
        return $this->description;
    }
}
