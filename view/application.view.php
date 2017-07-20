<h1 class="center">Envoi de candidature</h1>

<form action="index.php?page=application" method="POST">
    <!-- recruiter block, with email, name, gender, etc... -->
    <fieldset class="row" id="block-recruiter">
        <label class="small-margin-top" for="form-application[email]">Email</label><br />
        <input type="email" id="form-application[email]" name="form-application[email]" placeholder="demontigny.jeangilles@protonmail.com" class="col-xs-12"/>
        <label class="small-margin-top" for="form-application[fullname]">Civilité</label><br />
        <input type="text" id="form-application[fullname]" name="form-application[fullname]" placeholder="Mr De Montigny Jean-Gilles"  class="col-xs-12"/>
        <label class="small-margin-top" for="form-application[company]">Entreprise</label><br />
        <input type="text" class="col-xs-12" id="form-application[company]" name="form-application[company]" placeholder="Jean-Gilles inc." />
    </fieldset>
    <!-- motivation customization block -->
    <fieldset class="row" id="block-motivation-custom">
        <label class="small-margin-top" for="form-application[motivation]">Personnaliser la lettre de motivation</label>
        <textarea name="form-application[motivation]" id="form-application[motivation]" rows="10" class="col-xs-12" placeholder="En vrai, j'ai cher envie de taffer chez vous !"></textarea>
    </fieldset>
    <fieldset class="row">
        <input type="submit" class="col-xs-1 col-xs-offset-11 btn btn-default small-margin-top" />
    </fieldset>
</form>