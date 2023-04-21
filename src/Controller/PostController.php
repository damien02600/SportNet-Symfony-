<?php

// Je créer un HomeController qui sera le controller de ma page home.html.twig, ce sera ma page d'accueil de mon site
namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/* 
Je créer une class HomeController qui a le meme nom que mon controller, 
cette class étends AbstractController qui elle contient la méthode render.
La méthode render permet d'afficher la vue dans la page home.html.twig.
*/

class PostController extends AbstractController
{
    /* 
    ROUTE permet de diriger sur quelle page le controller fera effets.
    On lui mets un path (un chemin) et un name (home.index).
    */
    #[Route("/post", "post.index")]

    /* 
    Je créer une fonction index qui me retourne une Response qui vient du HttpFoundation du composant Symfony.
    Une Response est un objet qui envoie les info à partir d'une demande.
    */
    public function index(PostRepository $repository): Response
    {
        /* 
        Je lui retourne la méthode render.
        La méthode render permet d'afficher la vue dans la page home.html.twig.
        */
        return $this->render('pages/post/post.html.twig', [
            /**
             * Je dit que ingrédients est égal, j'appelle le repository est je fais un findAll.
             * FindAll permet de récuperer tout les données dans la base de donnée
             */
            'post' => $repository->findAll()
        ]);
    }
}
