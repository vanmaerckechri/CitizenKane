<?php 
$headDescription = "Restaurant à Wavre, page d'identification.";
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Modification du compte';

ob_start();
if ($pwdOrMail == "resetPwd")
{
?>
	<div id="main" class="main mainAuth">
		<form id="resetPwd" method="post" action="./index.php?action=admin">
			<fieldset>
    			<legend class="underline">Modification du Mot de Passe</legend>
       			<label for="newPwd">Nouveau Mot de Passe</label>
       			<input id="newPwd" type="password" name="newPwd">
       			<label for="newPwdRepeat">Répéter le Mot de Passe</label>
       			<input id="newPwdRepeat" type="password" name="newPwdRepeat">
       			<input type="hidden" name="resetCode" value="<?= $_GET["code"] ?>">
       			<a id="toggleAuthButton" class="authForgetPwd" href="./index.php?action=admin">Retour sur la page d'authentification</a>
                        <?php
       			if ($admin === true)
       			{
       			?>
       				<input type="submit" value=valider>
       			<?php
       			}
       			else
       			{
       			?>
       				<div class="g-recaptcha" data-sitekey="<?= Connexion::getCaptchaPublicKey() ?>" data-callback="submitForm"></div>
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
		<form id="formAuth" method="post" action="./index.php?action=admin">
			<fieldset>
    			<legend class="underline">Modification de l'Adresse Mail</legend>
       			<label for="newMail">Nouvelle Adresse Mail</label>
       			<input id="newMail" type="email" name="newMail">
       			<label for="newMailRepeat">Répéter l'Adresse Mail</label>
       			<input id="newMailRepeat" type="email" name="newMailRepeat">
       			<input type="hidden" name="resetCode" value="<?= $_GET["code"] ?>">
       			<input type="submit" value=valider>
       		</fieldset>
		</form>
	</div>
<?php
}
$content = ob_get_clean();

ob_start();?>
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
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