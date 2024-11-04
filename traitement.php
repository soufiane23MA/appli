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
* cette condition nous pérmet de vérifier que l'utilisateur a valider le formulaire
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
"name" => $name,
"price" => $price,
"qtt" => $qtt,
"total" => $price * $qtt
];

/**
* cette superglobale($ _SESSION) est générer automatiquement : soit par le serveur quand l'utilisateur
* envoie une requette, sinon PHP s'occupe de la créer ,
* et elle permet de rajouter les produits dynamiquement , comme une (array_push).
* et permet de sauvgarder les produits en memoir même l'utilisateur prorsuit sa navigation
* sur d'autres pages .
*/

$_SESSION['products'][] = $product;
$_SESSION['message'] = "<h3 style = 'color:black'>Votre Produit a éte rajouté   </h3>";
}
else{
	$_SESSION['message'] = "<h3 style ='color: red'> Attention!! Aucun produit n'a été rajouté</h3> ";

}
};
/**
 * la mise enplace de la boucle Switch qui gére l'affichge selon 
 * l'action choisi par l'utilisateur
 * /**
 * en bas : la condition qui permet de suprimer le produit clické (1 seul produit)
 * je verifier que le produit existe et que le paramétre 'action' avec comme valeur (supprimer/ delete)
 *  est dans l'URL reçus par recap.php, via le lien que j'ai crée dans le tableau( index.php )
 *  je vérifie également que le paramétre 'index' exist et que c'est un entier (# de NULL)
 */
 
if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'delete':
			if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['index'])) {
				$index = (int) $_GET['index'];
				if (isset($_SESSION['products'][$index])) {
					unset($_SESSION['products'][$index]); // Supprime le produit
					$_SESSION['products'] = array_values($_SESSION['products']); // Ré-indexe le tableau
					$_SESSION['message'] = "Le produit a été supprimé.";
				}
			}
			break;
			/**
			 * ici on fais les vérification de l'action de l'utilisateur et
			 * on supprime le contenu de la SESSION avec la methode ( unset ())
			 * la SESSION existera tjr jusqu'a l'utilisation de la methode (destroy())
			 * ou que l'utilisateur quitte le navigateur .
			 */
		case "clear":
			if (isset($_GET["action"]) && $_GET["action"] == "clear") {
				unset($_SESSION['products']);
				$_SESSION['message'] = 'Votre Panier est Vide';
			}
			break;
			/**
			 * le cas ou le clinet réduit la quantité de produit dans le panier
			 * aprés la verification de l présence du produit dans le panier (verification de la valeur de l'index) 
			 * et que la quantitée est superieur à 1, on déduit tjr par 1 la quantitée
			 */
		case 'decrease':
			if (isset($_GET['action']) && $_GET['action'] == 'decrease' && isset($_GET['index'])) {
				$index = (int) $_GET['index'];
				if (isset($_SESSION['products'][$index]) && $_SESSION['products'][$index]['qtt'] > 1) {
					$_SESSION['products'][$index]['qtt']--;
					$_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['qtt'] * $_SESSION['products'][$index]['price'];
					$_SESSION['message'] = "<h3 style='color:red'> Votre produit a été bien supprimé </h3>.";
				}
			}
			break; 
			/**
			 * ici le cas contraire , aprés les vérifications , on augmente la quantitée du produit choisi.
			 */
		case "increase":
			if (isset($_GET['action']) && $_GET['action'] == 'increase' && isset($_GET['index'])) {
				$index = (int) $_GET['index'];
				if (isset($_SESSION['products'][$index])) {
					$_SESSION['products'][$index]['qtt']++;
					$_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['qtt'] * $_SESSION['products'][$index]['price'];
					$_SESSION['message'] = "<h3 style='color:green'>Votre produit a été bien rajouté</h3>";
				}

			}
			;
			break;
	}
}


header("Location: recap.php");
exit;
 