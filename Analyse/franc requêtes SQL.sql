--
-- Affiché le produit en fonction de la catégorie
--
SELECT produit.id,produit.titre,produit.description,produit.prix,produit.quantite,produit.image, categorie.libelle 
AS catégorie 
FROM produit 
LEFT JOIN categorie 
ON categorie_id = categorie.id
WHERE categorie_id =1
ORDER BY id ASC;

--
-- Permet d'afficher les produits en fonction de la catégorie
--
SELECT categorie.id,categorie.libelle,produit.id,produit.titre,produit.description,produit.prix,produit.quantite,produit.image
FROM categorie
LEFT JOIN produit
ON categorie.id = produit.categorie_id
WHERE categorie.id =1
ORDER BY produit.id;

--
-- Permet d'afficher l'administrateur classé par ordre du plus ancien et limité à 1
--
SELECT * FROM admin ORDER BY id DESC LIMIT 1;

--
-- Permet d'afficher les commentaires cher l'administrateur
--
SELECT commentaire.id,commentaire.nom,commentaire.email,commentaire.comment,commentaire.date, produit.titre 
AS titre 
FROM commentaire 
LEFT JOIN produit
ON commentaire.produit_id = produit.id
WHERE commentaire.seen = '0'
ORDER BY commentaire.date ASC