<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajout Produit</title>
</head>

<body>
	<!--création du formulaire qui permettra de renseigner les produits-->
	<h1>Ajouter un Produit</h1>
	<!-- l'attribut action permet de désignié la destination de notre formulaire
	 et la methode nous informe le serveur que les informations sont récupereés
	 par un formulaire et ne pas via l'URL (methode GET)-->
	<form action="traitement.php" method="post">
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
			<input type="submit" name="submit" value="Ajouter le produit">
		</p>

	</form>

</body>

</html>