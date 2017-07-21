<!-- Upload CV on server -->
<section> 
    <h1 class="center">Sélection du CV</h1>
    <fieldset class="row">
        <form action="index.php?page=motivation&target=cv" method="POST" enctype="multipart/form-data">
            <label for="form-motivation[cv]" class="col-xs-12 small-margin-top">Sélectionnez votre CV (pdf uniquement)</label><br />
            <input type="file" class="col-xs-12" id="form-motivation[cv]" name="form-motivation[cv]" required/>
            <input type="submit" class="col-xs-1 col-xs-offset-11 small-margin-top btn btn-default" value="Télécharger" />    
        </form>
    </fieldset>
</section>

<!-- Write motivation letter -->
<section> 
    <h1 class="center">Lettre de motivation</h1>

    <form action="index.php?page=motivation&target=motivation" method="POST">
        <fieldset class="row">
            <label for="form-motivation[contact]" class="col-xs-12 small-margin-top">Coordonnées</label>
            <textarea id="form-motivation[contact]" name="form-motivation[contact]" class="col-xs-12" rows="8" placeholder="Nom, prénom, adresse, tel, mail, etc..." required><?php echo $motivation['contact']; ?></textarea>
        </fieldset>
        
        <fieldset class="row">
            <label for="form-motivation[subject]" class="col-xs-12 small-margin-top">Objet</label>
            <input type="text" id="form-motivation[subject]" name="form-motivation[subject]" class="col-xs-12" placeholder="Candidature au poste pète sa maman" required value="<?php echo $motivation['subject']; ?>" />
        </fieldset>

        <fieldset class="row">
            <label for="form-motivation[content]" class="col-xs-12 small-margin-top">Contenu</label>
            <p class="small-info col-xs-12">Pour ajouter un paragraphe personnalisé lors de certains envoi, insérer la balise <em>%s</em> à l'endroit  voulu.</p>
            <textarea name="form-motivation[content]" id="form-motivation[content]" class="col-xs-12" rows="30" placeholder="Viens, on dit tu m'embauches !" required><?php echo $motivation['content']; ?></textarea>
        </fieldset>

        <fieldset class="row">
            <input class="btn btn-default col-xs-1 col-xs-offset-11 small-margin-top" type="submit" value="Enregistrer" id="form-motivation-submit" />
        </fieldset>

    </form>
</section>