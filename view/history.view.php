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
    <table class="table table-stripped">
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
?>
        <tr>
            <td class="hidden" id="id-<?php echo $application['id']; ?>"><?php echo $application['id'] ?></td>
            <td class="hidden" id="salutation-<?php echo $application['id']; ?>"><?php echo $application['salutation'] ?></td>
            <td class="hidden" id="motivation-<?php echo $application['id']; ?>"><?php echo $application['customized-motivation'] ?></td>
            <td id="company-<?php echo $application['id']; ?>"><?php echo $application['company'] ?></td>
            <td id="email-<?php echo $application['id']; ?>"><?php echo $application['email'] ?></td>
            <td id="first_sent_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['first_sent_date']); ?></td>
            <td id="last_sent_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['last_sent_date']); ?></td> 
            <td id="answer_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['answer_date']); ?></td> 
            <td id="meeting_date-<?php echo $application['id']; ?>"><?php echo setDateFormat($application['meeting_date']); ?></td> 
        </tr>
<?php             
    }
?>
    </table>
<?php
}