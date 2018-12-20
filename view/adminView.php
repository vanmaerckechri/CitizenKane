<?php 
$headDescription = "Restaurant à Wavre, page d'identification.";
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Authentification';

ob_start();
if ($admin === true)
{
?>
	<div id="main" class="main mainAuth">
		<h2>Administration du Compte</h2>
		<button class="btn btn_admin">Modifier le mot de passe</button>
		<button class="btn btn_admin">Modifier l'adresse mail</button>
		<button id="disco" class="btn btn_admin">Se déconnecter</button>
	</div>
<?php
}
else
{
?>
	<div id="main" class="main mainAuth">
		<form id="formAuth" method="post" action="./index.php?action=admin">
			<fieldset>
    			<legend class="underline">Connexion</legend>
    			<?= $alertSms ?>
       			<label for="email">Adresse Mail</label>
       			<input id="email" type="text" name="email">
       			<label for="pwd">Mot de Passe</label>
       			<input id="pwd" type="password" name="pwd">
       			<a id="toggleForgetPwdButton" class="authForgetPwd" href="./index.php?action=admin">Mot de passe oublié ?</a>
       			<div class="g-recaptcha" data-sitekey="<?= Connexion::getCaptchaPublicKey() ?>" data-callback="submitForm"></div>
       			<input type="submit" value=valider>
       		</fieldset>
		</form>
		<form id="formForgetPwd" class="displayNone" method="post" action="./index.php?action=admin">
			<fieldset>
    			<legend class="underline">Mot de Passe Oublié ?</legend>
       			<label for="mailForChangePwd">Veuillez entrer votre adresse mail</label>
       			<input id="mailForChangePwd" type="text" name="mailForChangePwd">
       			<a id="toggleAuthButton" class="authForgetPwd" href="./index.php?action=admin">Retour sur la page d'authentification</a>
       			<div class="g-recaptcha" data-sitekey="<?= Connexion::getCaptchaPublicKey() ?>" data-callback="submitForm"></div>
       		</fieldset>
		</form>
	</div>
<?php
}
$content = ob_get_clean();

ob_start();?>
	<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
	<script type="text/javascript">
		"use strict";
	<?php
	if ($admin === true)
	{
	?>
		let disco = document.getElementById("disco");

		let createForm = function(inputName)
		{
			let form = document.createElement("form");
			let input = document.createElement("input");

			form.setAttribute("method", "post");
			form.setAttribute("action", "./index.php?action=admin");
			form.style.display = "none";
			input.setAttribute("type", "text");
			input.setAttribute("name", inputName);

			form.appendChild(input);
			document.body.appendChild(form);

			return form;
		}

		let disconnect = function()
		{
			let form = createForm("disco");
			form.submit();
		}

		disco.addEventListener("click", disconnect, false);
	<?php
	}
	else
	{
	?>
		let formForgetPwd = document.getElementById("formForgetPwd");
		let formAuth = document.getElementById("formAuth");
		let toggleForgetPwdButton = document.getElementById("toggleForgetPwdButton");
		let toggleAuthButton = document.getElementById("toggleAuthButton");

		function submitForm(event)
		{
			let formToSend = !formAuth.classList.contains("displayNone") ? formAuth : formForgetPwd;
			formToSend.submit();
		}

		let toogleForm = function(event)
		{
			event.preventDefault();
				
			formAuth.classList.toggle("displayNone");
			formForgetPwd.classList.toggle("displayNone");
		}

		let initEvents = function()
		{
			toggleForgetPwdButton.addEventListener("click", toogleForm, false);
			toggleAuthButton.addEventListener("click", toogleForm, false);
		}

		initEvents();
	<?php
	}
	?>
	</script>
<?php $javascript = ob_get_clean();

require('template.php'); ?>