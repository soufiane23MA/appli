<?php
session_start();

// Vérifie si le paramètre "action" existe dans l'URL
if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'add':
			// Code pour ajouter un produit
			if (isset($_POST['product_name'], $_POST['product_price'], $_POST['product_quantity'])) {
				$product = [
					'name' => htmlspecialchars($_POST['product_name']),
					'price' => (float)$_POST['product_price'],
					'qtt' => (int)$_POST['product_quantity'],
					'total' => (float)$_POST['product_price'] * (int)$_POST['product_quantity']
				];
				$_SESSION['products'][] = $product;
				$_SESSION['message'] = "Produit ajouté avec succès.";
			}
			break;

		case 'delete':
			// Code pour supprimer un produit spécifique
			if (isset($_GET['index']) && isset($_SESSION['products'][$_GET['index']])) {
				unset($_SESSION['products'][$_GET['index']]);
				$_SESSION['products'] = array_values($_SESSION['products']); // Ré-indexe le tableau
				$_SESSION['message'] = "Produit supprimé.";
			}
			break;

		case 'clear':
			// Code pour vider tout le panier
			unset($_SESSION['products']);
			$_SESSION['message'] = "Tous les produits ont été supprimés.";
			break;

		case 'up-qtt':
			// Code pour augmenter la quantité d'un produit
			if (isset($_GET['index']) && isset($_SESSION['products'][$_GET['index']])) {
				$_SESSION['products'][$_GET['index']]['qtt']++;
				$_SESSION['products'][$_GET['index']]['total'] = $_SESSION['products'][$_GET['index']]['price'] * $_SESSION['products'][$_GET['index']]['qtt'];
				$_SESSION['message'] = "Quantité augmentée.";
			}
			break;

		case 'down-qtt':
			// Code pour diminuer la quantité d'un produit
			if (isset($_GET['index']) && isset($_SESSION['products'][$_GET['index']]) && $_SESSION['products'][$_GET['index']]['qtt'] > 1) {
				$_SESSION['products'][$_GET['index']]['qtt']--;
				$_SESSION['products'][$_GET['index']]['total'] = $_SESSION['products'][$_GET['index']]['price'] * $_SESSION['products'][$_GET['index']]['qtt'];
				$_SESSION['message'] = "Quantité diminuée.";
			}
			break;
	}
}

// Redirige vers la page de récapitulatif après l'action
header('Location: recap.php');
exit;
