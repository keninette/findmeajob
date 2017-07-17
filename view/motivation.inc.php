<form id="form-motivation" action="" method="POST">
    <fieldset class="row">
        <label for="form-motivation['subject']">Objet</label>
        <input type="text" id="form-motivation['subject']" name="form-motivation['subject']" />
    </fieldset>
    <fieldset class="row">
        <label for="form-motivation['content']">Contenu</label>
        <p class="small-info">Si vous souhaitez adapter votre lettre de motivation lors de certains envoi, insérer la balise %s (il doit s'agir d'un paragraphe entier).</p>
        <textarea name="form-motivation['content']" id="form-motivation['content']" cols="30" rows="10"></textarea>
    </fieldset>
    <fieldset class="row">
        <input type="submit" value="Enregistrer" name="form-motivation-submit" />
    </fieldset>
</form>