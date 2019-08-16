<?php 

require_once 'app/Models/Printable.php';

use App\Models\Printable;

function printElement (Printable $job) 
{ ?>
    <li class="work-position">
        <h5><?= $job->getTitle(); ?></h5>
        <p><?= $job->getDescription(); ?></p>
        <p><?= $job->getDurationAsString(); ?></p>
      <strong>Achievements:</strong>
      <ul>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
      </ul>
    </li>
<?php }