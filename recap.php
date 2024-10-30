<?php

/**
 * cette page va me permettre d'affiche tous le contenu dans le tableau $_SESSION.
 * on commence toujour par cette fonction qui permettra l'affichage de la sesson
 */
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Récapitulatif des Produits</title>
</head>

<body>
	<?php
	/**
	 * ici j'ai mis en place une condition  avec un message destiné à l'utilisateur, pour s'assuérer que mon tableau
	 * $_SESSIOn n'est pas vide et et il existe .
	 * et j'organise l'affichage dans un tableau
	 */

	if (!isset($_SESSION["products"]) || empty($_SESSION['products'])) {
		echo "<p>Aucun Produits en session...</p>";
	} else {
		echo "<table>",
		"<thead>",
		"<tr>",
		"<th>#</th>",
		"<th>Nom</th>",
		"<th>Prix</th>",
		"<th>Quantité</th>",
		"<th>Total</th>",
		"</tr>",
		"</thead>",
		//"</table>",
		"<tbody>";
		/**
		 * initialiser le totalgenaral,et parcourir le tableau de la session avec tous les produits
		 * 
		 */

		$totalGeneral = 0;
		foreach ($_SESSION['products'] as $index => $product) {

			echo "<tr>",
			"<td>" . $index . "</td>",
			"<td>" . $product['name'] . "</td>",
			/*"<td>" . $product['price'] . "</td>",*/ "<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€" . "</td>",
			"<td>" . $product['qtt'] . "</td>",
			/*"<td>" . $product['total'] . "</td>",*/ "<td>" . number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€" . "</td>",
			"</tr>";

			$totalGeneral += $product['total'];
		}
		echo "<tr>",
		"<td colspan=4> Total général : </td>",
		"<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") . "&nbsp;€</strong></td>",
		"</tr>",
		"</tbody>",
		"</table>";
	};
	 

	?>
</body>

</html>