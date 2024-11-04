<?php

/**
 * cette page va me permettre d'affiche tous le contenu dans le tableau $_SESSION.
 * on commence toujour par cette fonction qui permettra l'affichage de la sesson
 */
session_start();
/**
 * en bas : la condition qui permet de suprimer le produit clické (1 seul produit)
 * je verifier que le produit existe et que le paramétre 'action' avec comme valeur (supprimer/ delete)
 *  est dans l'URL reçus par recap.php, via le lien que j'ai crée dans le tableau( index.php )
 *  je vérifie également que le paramétre 'index' exist et que c'est un entier (# de NULL)
 */

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['index'])) {
	$index = (int) $_GET['index'];
	if (isset($_SESSION['products'][$index])) {
		unset($_SESSION['products'][$index]); // Supprime le produit
		$_SESSION['products'] = array_values($_SESSION['products']); // Ré-indexe le tableau
		$_SESSION['message'] = "Le produit a été supprimé.";
	}
};
/**
 * la verification de l'action tous supprimé , 
 * là on suprime tous les produits on utilisant la valeur Clear pour le paramétre de l'URL
 * et on utilise la fonction (methode) unset avec comme paramétre le tableau des produits de la session 
 * et on envoie un message pour dire que le panier est vidée.
 */
if (isset($_GET["action"]) && $_GET["action"] == "clear") {
	unset($_SESSION['products']);
	$_SESSION['message'] = 'Votre Panier est Vide';
};
/**
 * la fonction qui permet d'augmenter la quantité de produits
 */

if (isset($_GET['action']) && $_GET['action'] == 'increase' && isset($_GET['index'])) {
	$index = (int)$_GET['index'];
	if (isset($_SESSION['products'][$index])) {
		$_SESSION['products'][$index]['qtt']++;
		$_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['qtt'] * $_SESSION['products'][$index]['price'];
		$_SESSION['message'] = "<h3 style='color:green'>Votre produit a été bien rajouté</h3>";
	}
};
/**
 * la fonction qui permet de réduire la quantité de produit dans le panier
 */
if (isset($_GET['action']) && $_GET['action'] == 'decrease' && isset($_GET['index'])) {
	$index = (int)$_GET['index'];
	if (isset($_SESSION['products'][$index]) && $_SESSION['products'][$index]['qtt'] > 1) {
		$_SESSION['products'][$index]['qtt']--;
		$_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['qtt'] * $_SESSION['products'][$index]['price'];
		$_SESSION['message'] = "<h3 style='color:red'> Votre produit a été bien supprimé </h3>.";
	}
};


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

			echo "<tr>",
			"<td>" . $index . "</td>",
			"<td><a href='recap.php?action=delete&index=$index'>Supprimer</a></td>", //le lien pour suprimer les produits
			"<td>" . $product['name'] . "</td>",
			//"<td>" . $product['price'] . "</td>",  comme c'est nombre en utilise le format 
			"<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€" . "</td>",
			"<td>" . "<a href='recap.php?action=decrease&index=$index'>-</a> " . $product['qtt'] . " <a href='recap.php?action=increase&index=$index'>+</a></td>",
			//"<td>" . $product['total'] . "</td>",
			"<td>" . number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€" . "</td>",
			"</tr>";

			$totalGeneral += $product['total'];
			/**
			 * qqtgenerale va accumuler tous les quantités de la session
			 * et j 'ai rajouter l'affichage du total des quantité dans le tableau
			 */
			$qqtGenaral += $product['qtt'];
		}
		echo "<tr>",
		"<td colspan=5> Total général : </td>",
		//"<td  >".$qqtGenaral."</td>",
		"<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") . "&nbsp;€</strong></td>",
		"</tr>",
		"</tbody>",
		"</table>";;
	};

	?>







</body>

</html>