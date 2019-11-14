<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }

    /**
     * @Route("/categories/ajouter", name="categorie_ajouter")
     */
    public function ajouter()
    {
        $categorie = new Categorie();

        //Création form
        $formulaire=$this->createForm(CategorieType::class, $categorie);

        return $this->render('categories/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Ajouter une catégorie"
        ]);
    }
}
