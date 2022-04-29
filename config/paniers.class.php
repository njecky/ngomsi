<?php

function creationPanier(){
	if (!isset($_SESSION['panier'])) {
		$_SESSION['panier'] = array();
		$_SESSION['panier']['titreProduit'] = array();
		$_SESSION['panier']['quantiteProduit'] = array();
		$_SESSION['panier']['descriptionProduit'] = array();
		$_SESSION['panier']['prixProduit'] = array();
		$_SESSION['panier']['imageProduit'] = array();
		$_SESSION['panier']['verrou'] = false;
	}
	return true;
}
function ajouterArticle($titreProduit,$quantiteProduit,$descriptionProduit,$prixProduit,$imageProduit){
	if (creationPanier() && !isVerrouille()) {
		$position_produit = array_search($titreProduit,$_SESSION['panier']['titreProduit']);

		if ($position_produit !=false) {
			$_SESSION['panier']['titreProduit'][$position_produit] += $quantiteProduit;
		}else{
			array_push($_SESSION['panier']['titreProduit'],$titreProduit);
			array_push($_SESSION['panier']['quantiteProduit'],$quantiteProduit);
			array_push($_SESSION['panier']['descriptionProduit'],$descriptionProduit);
			array_push($_SESSION['panier']['prixProduit'],$prixProduit);
			array_push($_SESSION['panier']['imageProduit'],$imageProduit);
		}
	}else{
		echo "Erreur, veuillez contacter l'administrateur";
	}
}

function ModifierQuantitéProduit($titreProduit,$quantiteProduit){
	if (creationPanier() && !isVerrouille()) {
		if ($quantiteProduit>0) {
			$position_produit = array_search($_SESSION['panier']['titreProduit'],$titreProduit);
			if ($position_produit!==false) {
				$_SESSION['panier']['titreProduit'][$position_produit] = $quantiteProduit;
			}
		}else{
			supprimerProduit($titreProduit);
		}
	}else{
		echo "Erreur, veuillez contacter l'administrateur";
	}
}

function supprimerArticle($titreProduit){
	if (creationPanier() && !isVerrouille()) {
		$tmp = array();
		$tmp['titreProduit'] = array();
		$tmp['quantiteProduit'] = array();
		$tmp['descriptionProduit'] = array();
		$tmp['prixProduit'] = array();
		$tmp['imageProduit'] = array();
		$tmp['verrou'] = array();
		for ($i; $i < count($_SESSION['panier']['titreProduit']); $i++) {
			if ($_SESSION['panier']['titreProduit'][$i] !== $titreProduit) {
				array_push($_SESSION['panier']['titreProduit'],$_SESSION['panier']['titreProduit'][$i]);
				array_push($_SESSION['panier']['quantiteProduit'],$_SESSION['panier']['quantiteProduit'][$i]);
				array_push($_SESSION['panier']['descriptionProduit'],$_SESSION['panier']['descriptionProduit'][$i]);
				array_push($_SESSION['panier']['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
				array_push($_SESSION['panier']['imageProduit'],$_SESSION['panier']['imageProduit'][$i]);
			}
		}
		$_SESSION['panier'] = $tmp;
		unset($tmp);
	}else{
		echo "Erreur, veuillez contacter l'administrateur";
	}
}

function isVerrouille(){
	if (isset($_SESSION['panier']) && $_SESSION['isVerrouille']) {
		return true;
	}else{
		return false;
	}
}

function compterProduit(){
	if (isset($_SESSION['panier'])) {
		return count($_SESSION['panier']['titreProduit']);
	}else{
		return 0;
	}
}

function supprimerPanier(){
	if (isset($_SESSION['panier'])) {
		unset($_SESSION['panier']);
	}
}

function montantGlobal(){
	$total = 0;
	for ($i; $i < count($_SESSION['panier']['titreProduit']); $i++) {
		$total += $_SESSION['panier']['quantiteProduit'][$i]*$_SESSION['panier']['prixProduit'];
	}
	return $total;
}
function montantGlobalTVA(){
	$total = 0;
	$total1 = ($total*19.25)/100;
	for ($i; $i < count($_SESSION['panier']['titreProduit']); $i++) {
		$total += $_SESSION['panier']['quantiteProduit'][$i]*$_SESSION['panier']['prixProduit'];
	}
	return $total + $total1;
}

function refresh($titreProduit,$quantiteProduit){
	if (creationPanier() && !isVerrouille()) {
		if ($quantiteProduit>0) {
			# code...
		}
	}else{
		echo"Erreur, veuillez contacter l'administrateur";
	}
}
