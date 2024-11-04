<?php

/**
 * cette page va me permettre d'affiche tous le contenu dans le tableau $_SESSION.
 * on commence toujour par cette fonction qui permettra l'affichage de la sesson
 */
session_start();

$qqtGenaral = 0;
if (isset($_SESSION['products'])) {
	foreach ($_SESSION['products'] as $product) {
		$qqtGenaral += $product['qtt'];
	}
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Récapitulatif des Produits</title>
	<link rel="stylesheet" href="styles/recap_style.css">
</head>

<body>

	<div class="navbare">
		<div class="navlinks">
			<ul>

				<li><a href="index.php">Accueil</a></li>
				<li><a href="recap.php">Recap</a></li>
				<li id="total">Total Produits :<?php echo $qqtGenaral; ?> </li>
			</ul>
		</div>

	</div>
	<?php
	// l'affichage des différents messages

	if (isset($_SESSION['message'])) {
		echo "<h3 class='message'> {$_SESSION['message']}</h3>";
		unset($_SESSION['message']);
	}

	/**
	 * ici j'ai mis en place une condition  avec un message destiné à l'utilisateur, pour s'assuérer que mon tableau
	 * $_SESSIOn n'est pas vide et et il existe .
	 * et j'organise l'affichage dans un tableau
	 */

	if (!isset($_SESSION["products"]) || empty($_SESSION['products'])) {
		echo "<h3>Aucun Produits en session...</h3>";
	} else {
		echo "<table class='product-table'>",
			"<thead>",
			"<tr>",
				"<th>#</th>",
				"<th>poubelle</th>",
				"<th>Nom</th>",
				"<th>Prix</th>",
				"<th>Quantité</th>",
				"<th>Total</th>",
			"</tr>",
			"</thead>",
		"<tbody>";


		/**
		 * initialiser le totalgenaral,et parcourir le tableau de la session avec tous les produits
		 * 
		 */

		$totalGeneral = 0;
		// declarer total des quantitées dans une varibale

		foreach ($_SESSION['products'] as $index => $product) {

			echo 
		"<tr>",
			"<td>" . $index . "</td>",
			"<td>
				<a href='traitement.php?action=delete&index=$index'>Supprimer</a>
			</td>", //le lien pour suprimer les produits
			"<td>" . $product['name'] . "</td>",
				//"<td>" . $product['price'] . "</td>",  comme c'est nombre en utilise le format 
			"<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€" . "</td>",
			"<td>" . 
				"<a href='traitement.php?action=decrease&index=$index'>-</a> " 
				. $product['qtt'] . 
				" <a href='traitement.php?action=increase&index=$index'>+</a>
			</td>",
				//"<td>" . $product['total'] . "</td>",
			"<td>" 
				. number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€" . 
			"</td>",
		"</tr>";

			$totalGeneral += $product['total'];
			/**
			 * qqtgenerale va accumuler tous les quantités de la session
			 * et j 'ai rajouter l'affichage du total des quantité dans le tableau
			 */
			$qqtGenaral += $product['qtt'];
		}
			echo 
				"<tr>",
					"<td colspan=5> Total général : </td>",
					//"<td  >".$qqtGenaral."</td>",
					"<td>
						<strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") . "&nbsp;€</strong>
					</td>",
				"</tr>",
		"</tbody>",
	"</table>";;
	};

	?>







</body>

</html>