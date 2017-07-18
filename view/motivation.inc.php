<form id="form-motivation" action="" method="POST">
    
    <fieldset class="row">
        <label for="form-motivation[subject]" class="col-xs-12">Objet</label>
        <input type="text" id="form-motivation[subject]" name="form-motivation[subject]" class="col-xs-12" value="<?php echo $subject; ?>" />
    </fieldset>
    
    <fieldset class="row">
        <label for="form-motivation[content]" class="col-xs-12">Contenu</label>
        <p class="small-info col-xs-12">Si vous souhaitez adapter votre lettre de motivation lors de certains envoi, insérer la balise %s (il doit s'agir d'un paragraphe entier).</p>
        <textarea name="form-motivation[content]" id="form-motivation[content]" class="col-xs-12" rows="35">
            <?php echo $content; ?>
        </textarea>
    </fieldset>
    
    <fieldset class="row">
        <input type="submit" value="Enregistrer" id="form-motivation-submit" />
    </fieldset>

</form>