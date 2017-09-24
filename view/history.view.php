<!-- table with all aplications -->
<section class="row medium-margin-left">
    
    <!---------------------- DISPLAY FILTERS -------------------->
    <section id="filters-section" class="row">
        <form method="POST" action="index.php?page=history&target=filter">
            <fieldset class="col-xs-6">
                <label for="application-filter[company]" class="col-md-4 col-xs-12 small-margin-top">Entreprise</label>
                <input name="application-filter[company]" id="application-filter[company]" type="text" list="company-data" value="<?php echo(isset($postFilters['company']) ? $postFilters['company'] : ''); ?>" class="datalist col-xs-12 col-md-8 small-margin-top"/>
                <datalist id="company-data">
                <?php
                    foreach ($companies as $thisCompany) {
                ?>
                    <option value="<?php echo $thisCompany; ?>"></option>
                <?php
                    }        
                ?>
                </datalist>
                <label for="application-filter[email]" class="col-md-4 col-xs-12 small-margin-top">Destinataire</label>
                <input name="application-filter[email]" id="application-filter[email]" type="text" list="recipients-data"  value="<?php echo(isset($postFilters['email']) ? $postFilters['email'] : ''); ?>"class="datalist col-xs-12 col-md-8 small-margin-top"/>
                <datalist id="recipients-data">
                <?php
                    foreach ($recipients as $thisRecipient) {
                ?>
                    <option value="<?php echo $thisRecipient; ?>"></option>
                <?php
                    }        
                ?>
                </datalist>
                <fieldset>
                    <label>Statut des candidatures</label> <br />
                    <input type="checkbox" name="application-filter[answer_date][]" value="true">
                    <label>Avec réponse</label>
                    <input type="checkbox" name="application-filter[answer_date][]" value="false">
                    <label>Sans réponse</label>
                    <input type="checkbox" name="application-filter[meeting_date][]" value="true">
                    <label>Avec rendez-vous</label>
                    <input type="checkbox" name="application-filter[meeting_date][]" value="false">
                    <label>Sans rendez-vous</label>
                </fieldset>
            </fieldset>
            <fieldset class="col-xs-6">
                <input type="submit" value="Filtrer" class="btn btn-default"/>
            </fieldset>   
        </form>
        <form method="POST" action="index.php?page=history&target=reset-filter">
            <input type="submit" value="Réinitialier les filtres" class="small-margin-top" />    
        </form>
    
<?php
// We only display table if there are some applications to display
if (isset($displayTable) && $displayTable) {
//     id
//                    , first_sent_date
//                    , last_sent_date
//                    , email
//                    , salutation
//                    , company
//                    , customized_motivation
?>    
        
    <!---------------------- DISPLAY TABLE -------------------->
    </section>
    <p class="small-info row">Sélectionnez une candidature pour la mettre à jour ou l'envoyer de nouveau.</p>
    <table class="table table-stripped row">
        <tr class="heading">
            <th class="hidden">Identifiant</th>
            <th class="hidden">Formule de salutation</th>
            <th class="hidden">Motivation personnalis&eacute;e</th>
            <th>Entreprise</th>
            <th>Email du contact</th>
            <th>Premier envoi</th>
            <th>Dernier rappel</th>
            <th>Date de la réponse</th>
            <th>Date de l'entretien</th>
        </tr>
<?php
    // for each application in array, we'll display a table line
    // every cell will have a custom id tag with application ID
    // so we know in javascript on which application we're working
    // you'll see my dear Mofo, it's very usefull
    // btw : except for some exceptions, you all display html this way when using php
    //      you close the php tag, and reopen it when you're done
    //      you almost NEVER display html in a php string
    //      that's good practice, and that's way easier to maintain
    foreach($applications as $application) {
        if ($application !== false) {
?>
        <tr id="tr-<?php echo $application['id']; ?>">
            <td class="hidden" id="id-<?php echo $application['id']; ?>"><?php echo $application['id']; ?></td>
            <td class="hidden" id="salutation-<?php echo $application['id']; ?>"><?php echo $application['salutation']; ?></td>
            <td class="hidden" id="motivation-<?php echo $application['id']; ?>"><?php echo $application['customized_motivation']; ?></td>
            <td id="company-<?php echo $application['id']; ?>"><?php echo $application['company']; ?></td>
            <td id="email-<?php echo $application['id']; ?>"><?php echo $application['email']; ?></td>
            <td id="first_sent_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['first_sent_date']); ?></td>
            <td id="last_sent_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['last_sent_date']); ?></td> 
            <td id="answer_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['answer_date']); ?></td> 
            <td id="meeting_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['meeting_date']); ?></td> 
        </tr>
<?php             
        }
    }
?>
    </table>
<?php
}
?>
</section>

<!---------------------- DISPLAY FORM -------------------->
<!-- form to update selected application, hidden at loadind. Made visible and pre-filled when a line of table is selected -->
<section id="application-forms" class="hidden row medium-margin-left">
    <form action="index.php?page=history&target=update" method="POST" class="row">
        <h2>Mettre à jour la candidature</h2>
        <!-- we put a hidden input to fill it with application ID : the user won't see it but it still will be in $_POST -->
        <input type="hidden" name ="application[id-update]" id="form-id-update" />
        <label for="application[answer_date]" class="col-xs-2">Date de réponse</label>
        <input type="date" id="form-answer_date" name="application[answer_date]" class="col-xs-2" />
        <label for="application[meeting_date]" class="col-xs-offset-1 col-xs-2">Date d'entretien</label>
        <input type="date" id="form-meeting_date" name="application[meeting_date]" class="col-xs-2"/>
        <input type="submit" value="Enregistrer" class="btn btn-default col-xs-1 col-xs-offset-2"/>
    </form>
    <form action="index.php?page=history&target=resend" method="POST" class="row">
        <h2>Renvoyer la candidature</h2>
        <!-- we put a hidden input to fill it with application ID : the user won't see it but it still will be in $_POST -->
        <input type="hidden" name ="application[id-resend]" id="form-id-resend" class="col-xs-12"/>
        <input type="hidden" name ="application[email]" id="form-email" class="col-xs-12"/>
        <label for="application[salutation]" class="col-xs-12">Salutation</label>
        <input type="text" id="form-salutation" name="application[salutation]" class="col-xs-12" />
        <label for="application[motivation]">Personnalisation de la lettre de motivation</label>
        <textarea name="application[motivation]" id="form-motivation" class="col-xs-12" rows="10"></textarea>
        <input type="submit" value="Envoyer" class="btn btn-default col-xs-offset-11 col-xs-1 small-margin-top"/>
    </form>  
</section>