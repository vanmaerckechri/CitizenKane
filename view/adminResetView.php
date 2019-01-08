<?php 
$headDescription = "Restaurant à Wavre, page d'identification.";
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Modification du compte';

ob_start();
if ($pwdOrMail == "resetPwd")
{
?>
	<div id="main" class="main mainAuth">
		<form id="resetPwd" class="inputRepeat-form" method="post" action="./index.php?action=admin">
			<fieldset>
    			<legend class="underline">Modification du Mot de Passe</legend>
             		<label for="newPwd">Nouveau Mot de Passe</label>
             		<input id="newPwd" class="inputRepeat-input1" type="password" name="newPwd">
             		<label for="newinputRepeat">Répéter le Mot de Passe</label>
             		<input id="newinputRepeat" class="inputRepeat-input2" type="password" name="newinputRepeat">
       			<input type="hidden" name="resetCode" value="<?= $_GET["code"] ?>">
       			<a id="toggleAuthButton" class="authForgetPwd" href="./index.php?action=admin">Retour sur la page d'authentification</a>
                        <?php
       			if ($admin === true)
       			{
       			?>
       				<input class="btn btn_admin inputRepeat-submit" type="submit" value=valider>
       			<?php
       			}
       			else
       			{
       			?>
       				<div class="g-recaptcha inputRepeat-submit" data-sitekey="<?= Connexion::getCaptchaPublicKey() ?>" data-callback="submitForm"></div>
       			<?php
       			}
       			?>
       		</fieldset>
		</form>
	</div>
<?php
}
else if ($pwdOrMail == "resetMail" && $admin === true)
{
?>
	<div id="main" class="main mainAuth">
		<form id="formAuth" class="inputRepeat-form" method="post" action="./index.php?action=admin">
			<fieldset>
    			<legend class="underline">Modification de l'Adresse Mail</legend>
       			<label for="newMail">Nouvelle Adresse Mail</label>
       			<input id="newMail" class="inputRepeat-input1" type="email" name="newMail">
       			<label for="newMailRepeat">Répéter l'Adresse Mail</label>
       			<input id="newMailRepeat" class="inputRepeat-input2" type="email" name="newMailRepeat">
       			<input type="hidden" name="resetCode" value="<?= $_GET["code"] ?>">
                        <a id="toggleAuthButton" class="authForgetPwd" href="./index.php?action=admin">Retour sur la page d'authentification</a>
       			<input class="btn btn_admin inputRepeat-submit" type="submit" value=valider>
       		</fieldset>
		</form>
	</div>
<?php
}
$content = ob_get_clean();

ob_start();?>
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
<script type="text/javascript" src="assets/js/cvm_inputrepeat.js"></script>
<?php
if ($admin === false)
{
?>
	<script type="text/javascript">
		function submitForm(event)
		{
			let resetPwd = document.getElementById("resetPwd");
			resetPwd.submit();
		}
	</script>
<?php
}
?>
<?php $javascript = ob_get_clean();

require('template.php'); ?>