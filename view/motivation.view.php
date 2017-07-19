<form id="form-motivation" action="index.php?page=motivation" method="POST">
    <fieldset class="row">
        <label for="form-motivation[subject]" class="col-xs-12">Objet</label>
        <input type="text" id="form-motivation[subject]" name="form-motivation[subject]" class="col-xs-12" value="<?php echo $motivation['subject']; ?>" />
    </fieldset>
    
    <fieldset class="row">
        <label for="form-motivation[content]" class="col-xs-12">Contenu</label>
        <p class="small-info col-xs-12">Pour ajouter un paragraphe personnalisé lors de certains envoi, insérer la balise <em>%s</em> à l'endroit  voulu.</p>
        <textarea name="form-motivation[content]" id="form-motivation[content]" class="col-xs-12" rows="30"><?php echo $motivation['content']; ?></textarea>
    </fieldset>
    
    <fieldset class="row">
        <input class="btn btn-default col-xs-1 col-xs-offset-11" type="submit" value="Enregistrer" id="form-motivation-submit" />
    </fieldset>

</form>