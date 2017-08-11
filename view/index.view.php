<?php

// Display data only if it has been successfully retrieved from database
if (isset($displayData) && $displayData) {
?>
<section class="row">
    <div class="col-xs-6 tile appeal-tile" id="total-applications-tile">
        <em><?php echo $data["applicationsNb"]; ?></em><br />Candidature(s) envoy&eacute;es
    </div>
    <div class="col-xs-6 tile default-tile">
        <input id="dial-answer" class="dial" type="text" value="<?php echo $data["answeredApplicationsNb"]; ?>" data-min="0" data-max="<?php echo $data["applicationsNb"]; ?>"/>
        <br />Candidature(s) avec réponse
    </div>
    <div class="col-xs-6 tile default-tile">
        <input id="dial-meeting" class="dial" type="text" value="<?php echo $data["meetingsGrantedNb"]; ?>" data-min="0" data-max="<?php echo $data["applicationsNb"]; ?>"/>
        <br />Entretien(s) décroché(s)
    </div>
    <div class="col-xs-6 tile default-tile" id="resend-nb-tile" title="Cliquez sur le cadre pour envoyer les relances de candidatures">
        Rappels
        <p>
            <i id="resend-nb-icon"class="fa fa-envelope fa-5x"></i>
            <span id="resend-nb"><?php echo $data["oldApplicationsNb"]; ?></span>
        </p>
    </div>
</section>
<?php
}