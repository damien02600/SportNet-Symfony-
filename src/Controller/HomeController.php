<?php

// Je créer un HomeController qui sera le controller de ma page home.html.twig, ce sera ma page d'accueil de mon site
namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/* 
Je créer une class HomeController qui a le meme nom que mon controller, 
cette class étends AbstractController qui elle contient la méthode render.
La méthode render permet d'afficher la vue dans la page home.html.twig.
*/

class HomeController extends AbstractController
{
    /* 
    ROUTE permet de diriger sur quelle page le controller fera effets.
    On lui mets un path (un chemin) et un name (home.index).
    */
    #[Route("/", "home.index")]

    /* 
    Je créer une fonction index qui me retourne une Response qui vient du HttpFoundation du composant Symfony.
    Une Response est un objet qui envoie les info à partir d'une demande.
    */
    public function index(PostRepository $postRepository): Response
    {
        /* 
        Je lui retourne la méthode render.
        La méthode render permet d'afficher la vue dans la page home.html.twig.
        */
        return $this->render('home.html.twig', [
            // J'affiche les recette public a la page d'accueil
            'post' => $postRepository->findPost(3)
        ]);
    }
}
