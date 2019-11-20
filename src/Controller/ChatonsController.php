<?php

namespace App\Controller;

use App\Entity\Chaton;
use App\Form\ChatonType;
use App\Repository\ChatonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatonsController extends AbstractController
{
    /**
     * @Route("/azerty", name="azerty")
     */
    public function index(ChatonRepository $repository)
    {
        $Chatons=$repository->findAll();
        return $this->render('Chatons/index.html.twig', [
            'chatons'=>$Chatons
        ]);
    }

    /**
     * @Route("/chatons/ajouter", name="chaton_ajouter")
     */
    public function ajouter(Request $request)
    {
        $Chaton = new Chaton();

        //Création form
        $formulaire=$this->createForm(ChatonType::class, $Chaton);

        //récup données POST
        $formulaire->handleRequest($request);

        //Enregistrer dans BDD
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récup de Entity manager
            $em=$this->getDoctrine()->getManager();

            //garder objet en BDD
            $em->persist($Chaton);

            //execute l'insert
            $em->flush();

            //je m'en vais
            return $this->redirectToRoute("home");
        }

        return $this->render('Chatons/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Ajouter un chaton"
        ]);
    }

    /**
     * @Route("/chatons/modifier/{id}", name="chaton_modifier")
     */
    public function modifier(ChatonRepository $repository, $id, Request $request)
    {
        //chercher objet à modif
        $Chaton = $repository->find($id);

        //Création form
        $formulaire=$this->createForm(ChatonType::class, $Chaton);

        //récup données POST
        $formulaire->handleRequest($request);

        //Enregistrer dans BDD
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récup de Entity manager
            $em=$this->getDoctrine()->getManager();

            //garder objet en BDD
            $em->persist($Chaton);

            //execute l'insert
            $em->flush();

            //je m'en vais
            return $this->redirectToRoute("home");
        }

        return $this->render('Chatons/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Modifier le chaton ".$Chaton->getTitre()
        ]);
    }

    /**
     * @Route("/chatons/supprimer/{id}", name="chaton_supprimer")
     */
    public function supprimer(ChatonRepository $repository, $id, Request $request)
    {
        //chercher objet à modif
        $Chaton = $repository->find($id);

        $formulaire=$this->createForm(ChatonType::class, $Chaton);
        $formulaire->handleRequest($request);

        //Enregistrer dans BDD
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->remove($Chaton);
            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('Chatons/formulaire.html.twig', [
            'formulaire'=>$formulaire->createView(),
            'h1'=>"Supprimer le chaton ".$Chaton->getTitre()
        ]);
    }
}
