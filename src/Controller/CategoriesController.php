<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategorieRepository $repository)
    {
        $categories=$repository->findAll();
        return $this->render('categories/index.html.twig', [
            'categories'=>$categories
        ]);
    }

    /**
     * @Route("/categories/ajouter", name="categorie_ajouter")
     */
    public function ajouter(Request $request)
    {
        $categorie = new Categorie();

        //Création form
        $formulaire=$this->createForm(CategorieType::class, $categorie);

        //récup données POST
        $formulaire->handleRequest($request);

        //Enregistrer dans BDD
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récup de Entity manager
            $em=$this->getDoctrine()->getManager();

            //garder objet en BDD
            $em->persist($categorie);

            //execute l'insert
            $em->flush();

            //je m'en vais
            return $this->redirectToRoute("home");
        }

        return $this->render('categories/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Ajouter une catégorie"
        ]);
    }

    /**
     * @Route("/categories/modifier/{id}", name="categorie_modifier")
     */
    public function modifier(CategorieRepository $repository, $id, Request $request)
    {
        //chercher objet à modif
        $categorie = $repository->find($id);

        //Création form
        $formulaire=$this->createForm(CategorieType::class, $categorie);

        //récup données POST
        $formulaire->handleRequest($request);

        //Enregistrer dans BDD
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récup de Entity manager
            $em=$this->getDoctrine()->getManager();

            //garder objet en BDD
            $em->persist($categorie);

            //execute l'insert
            $em->flush();

            //je m'en vais
            return $this->redirectToRoute("home");
        }

        return $this->render('categories/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Modifier la catégorie ".$categorie->getTitre()
        ]);
    }

    /**
     * @Route("/categories/supprimer/{id}", name="categorie_supprimer")
     */
    public function supprimer(CategorieRepository $repository, $id, Request $request)
    {
        //chercher objet à modif
        $categorie = $repository->find($id);

        $formulaire=$this->createForm(CategorieType::class, $categorie);
        $formulaire->handleRequest($request);

        //Enregistrer dans BDD
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('categories/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Supprimer la catégorie ".$categorie->getTitre()
        ]);
    }
}
