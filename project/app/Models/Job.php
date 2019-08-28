<?php 

namespace App\Models;

use App\Traits\HasDefaultImage;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasDefaultImage;

    protected $table = 'jobs';

    // public function __construct ($title, $description) {
    //     $newTitle = "Job: {$title}";
    //     parent::__construct($newTitle, $description);
    // }

    public function getDurationAsString()
    {
        $years = floor( $this->months / 12 );
        $extraMonths = $this->months % 12;

        return "Job duration: {$years} years {$extraMonths} monts";
    } 
}