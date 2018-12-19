<?php 
$headDescription = "Restaurant à Wavre, accessibilité de l'établissement et contact.";
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Infos & Contact';

ob_start(); ?>
	<div id="main" class="main">
		<section class="restaurant-intro contact-intro">
			<div>
				<h1>Infos & Contact</h1>
				<div>
					<h2>Adresses</h2>
					<ul>
						<li>Le Café-Resto : Rue Charles Sambon, 10 – Wavre (1300)</li>
						<li>Le Restaurant : Rue Charles Sambon, 13 – Wavre (1300)</li>
						<li>La Salle Vertigo : Rue Charles Sambon, 11 – Wavre (1300)</li>
					</ul>
					<h2>Parking</h2>
					<p>Parking Place Cardinal Mercier (54 places/payant la journée) – 1 minute à pied<br>Parking des mésanges (210 places/gratuit) – 5 minutes à pied</p>
					<h2>En Train ou en Bus</h2>
					<p>Gare de Wavre – 5 minutes à pied</p>
				</div>
				<div>
	    			<iframe title="googleMap" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2526.1842201982226!2d4.6086247!3d50.7165214!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x417232b93ee6ab5b%3A0x24192d639835ffdf!2sCitizen+Kane!5e0!3m2!1sfr!2sbe!4v1543086912665" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
	    		</div>
	    	</div>
		</section>
		<section class="contact-form">
			<form method="post" action="">
				<fieldset>
	    			<legend class="underline">Nous Contacter !</legend>
	       			<label for="contact_email">Adresse Mail</label>
	       			<input id="contact_email" type="email" name="contact_email">
	       			<label for="contact_name">Nom</label>
	       			<input id="contact_name" type="text" name="contact_name">
	       			<label for="contact_firstName">Prénom</label>
	       			<input id="contact_firstName" type="text" name="contact_firstName">
	       			<label for="contact_sujet">Objet</label>
	       			<input id="contact_sujet" type="text" name="contact_sujet">
	       			<label for="contact_message">Message</label>
	       			<textarea id="contact_message" name="contact_message">
					</textarea> 
	       			<input class="btn" type="submit" value="envoyer">
	       		</fieldset>
			</form>
		</section>
		<section class="home_form">
			<a href="https://fr.tripadvisor.be/Restaurant_Review-g188643-d7221922-Reviews-Citizen_Kane-Wavre_Walloon_Brabant_Province_Wallonia.html" target="_blank" rel="noopener"><img src="assets/img/logo_tripadvisor.svg" alt="le logo de tripadvisor"></a>
			<form method="post" action="">
				<fieldset>
	    			<legend class="underline">Inscrivez-vous à notre newsletter !</legend>
	       			<label for="email">Adresse Mail*</label>
	       			<input id="email" type="email" name="email" required>
	       			<label for="name">Nom</label>
	       			<input id="name" type="text" name="name">
	       			<label for="firstName">Prénom</label>
	       			<input id="firstName" type="text" name="firstName">
	       			<p>* = required field</p>
	       			<input class="btn" type="submit" value="inscription">
	       		</fieldset>
			</form>
		</section>
	</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start();?>
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
<?php $javascript = ob_get_clean(); ?>

<?php require('template.php'); ?>