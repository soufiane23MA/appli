<?php

session_start();


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajout Produit</title>
	<link rel="stylesheet" href="styles/index_style.css">
</head>

<body>

	<?php

	$qqtGenaral = 0;
	if (isset($_SESSION['products'])) {
		foreach ($_SESSION['products'] as $product) {
			$qqtGenaral += $product['qtt'];
		}
	};
	?>

	<div class="navbare">
		<div class="navlinks">
			<ul>
				<li><a href="index.php">Accueil</a></li>
				<li><a href="recap.php">Recap</a></li>
				<li id="total">Total Produits :<?php echo $qqtGenaral; ?> </li>
			<!-- crée le lien cliquable qui permet de suprimer tou les produit du tableau-->	
				<li><a href="recap.php?action=clear">Vider Votre Panier</a></li>
			</ul>
		</div>
	</div>
	<!--création du formulaire qui permettra de renseigner les produits-->
	<h1>Ajouter un Produit</h1>
	<?php
	
	// Affichage du message de retour

	if (isset($_SESSION['message'])) {
		echo "<p class='message'> {$_SESSION['message']}</p>";
		unset($_SESSION['message']);
		/**
		 * On supprime le message pour qu'il ne persiste pas
		 * le problem je n'arrive pas a enlevé le message de retour 
		 * je ne sais pas pourquoi.mlagré l'utilisation de unset.
		 */ 
	};
	?>

	<!-- l'attribut action permet de désignié la destination de notre formulaire
	 et la methode nous informe le serveur que les informations sont récupereés
	 par un formulaire et ne pas via l'URL (methode GET)-->

	<form class="form_produit" action="traitement.php" method="post">
		<p>
			<label>
				Nom du produit :
				<input type="text" name="name">
			</label>
		</p>
		<p>
			<label>
				Prix du Produit :
				<input type="number" step="any" name="price">
			</label>
		</p>
		<p>
			<label>
				Quantité Désirée :
				<input type="number" name="qtt" value="1">
			</label>
		</p>
		<p>
			<input class="submit" type="submit" name="submit" value="Ajouter le produit">
		</p>

	</form>



</body>

</html>