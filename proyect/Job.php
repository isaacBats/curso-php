<?php
/**
 * Short description for Job.php
 *
 * @package Job
 * @author daniel <daniel@daniel-lap-dell-l3560>
 * @version 0.1
 * @copyright (C) 2019 daniel <daniel@daniel-lap-dell-l3560>
 * @license MIT
 */
Class Job {
    private $title;
    public $description;
    public $visible;
    public $months;


    public function getTitle() 
    {
        return $this->title;
    }

    public function setTitle($title) 
    {
        $this->title = $title;
    }
}
