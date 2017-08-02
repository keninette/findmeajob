<?php

// Display data only if it has been successfully retrieved from database
if (isset($displayData) && $displayData) {
?>
<section class="row">
    <div class="col-xs-3 tile">Total : <?php echo $data[0]["applicationsNb"]; ?></div>
    <div class="col-xs-3 tile">Répondu : <?php echo $data[0]["answeredApplicationsNb"]; ?></div>
    <div class="col-xs-3 tile">Rdv : <?php echo $data[0]["meetingsGrantedNb"]; ?></div>
    <div class="col-xs-3 tile">Relances : <?php echo $data[0]["oldApplicationsNb"]; ?></div>
</section>
<?php
}