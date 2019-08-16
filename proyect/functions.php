<?php 

function printElement ($job) 
{ ?>
    <li class="work-position">
        <h5><?= $job->title; ?></h5>
        <p><?= $job->description; ?></p>
        <p><?= $job->getDurationAsString(); ?></p>
      <strong>Achievements:</strong>
      <ul>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
        <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>
      </ul>
    </li>
<?php }