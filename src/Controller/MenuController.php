<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function _menu(CategorieRepository $repository)
    {
        $cat=$repository->findAll();

        return $this->render('menu/_menu.html.twig', [
            'categorie'=>$cat
        ]);
    }
}
