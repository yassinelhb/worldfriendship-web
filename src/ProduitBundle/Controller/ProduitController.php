<?php

namespace ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProduitController extends Controller
{

    public function indexAction()
    {
        return $this->render('@Produit/index.html.twig');
    }

    public function categorieAction()
    {
        return $this->render('@Produit/categorie.html.twig');
    }

    public function produitAction()
    {
        return $this->render('@Produit/product.html.twig');
    }
    public function searchAction()
    {
        return $this->render('@Produit/search.html.twig');
    }
    public function panierAction()
    {
        return $this->render('@Produit/panier.html.twig');
    }
}
