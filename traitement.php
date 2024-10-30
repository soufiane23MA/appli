<?php
session_start();
/**
 * je fais appel à la fonction session_start pour enregistrer 
 * les élement du formulaire sur le serveur, de son côté le serveur
 * va crée un cooke PHPSESSID avec un identifiant de la session 
 * dans le navigateur client ( par dafaut : la durée de vie 
 * de ce cookie s'arrete avec la fermiture du navigateur )
 * ==> expiration Max-Age = session.
 */



/**
 *  cette condition nous pérmet de vérifier que l'utilisateur a valider le formulaire
 * on s'asssure que ce dernier n'a pas injecté du code HTML via les filtres 
 * (éviter la faille XSS( cross-site-scripting ))
 * la methode filter_input renvoi la valeur NULL, si un champ n'existe pas dans 
 * la requête Post.
 */


if (isset($_POST['submit'])) {

	$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

	/**
	 * on mis on place une nouvelle condition pour s'assurer que les filter_input
	 * ont bine fonctionnés et qu'on a belle et bien les 3 variables avec des valeurs bien nettoyées .
	 */
	if ($name && $price && $qtt) {
		/**
		 * aprés verification des valeurs de nos variables on les stoques dans la $_session crée 
		 * par PHP 
		 * on organise par la suite nos variable dans tableau assousiatif $product et on rajoute la 
		 * nouvelle attribut total.
		 */

		$product =
			[
				"name"  => $name,
				"price" => $price,
				"qtt"   => $qtt,
				"total" => $price * $qtt
			];

			/**
			 * cette superglobale($ _SESSION) est générer automatiquement : soit par le serveur quand l'utilisateur 
			 * envoie une requette, sinon PHP s'on occupe de la créer ,
			 * et elle permet de rajouter les produits dynamiquement , comme une (array_push).
			 * et permet de sauvgarder les produits en memoir même l'utilisateur prorsuit sa navigation
			 * sur d'autres pages .
			 */

		$_SESSION['products'][] = $product;
	}
}

/**
 * 
 */
header("Location:index.php");
