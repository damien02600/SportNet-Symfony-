<?php

// Je créer un PostController qui sera le controller de mes post
namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/* 
Je créer une class PostController qui a le meme nom que mon controller, 
cette class étends AbstractController qui elle contient la méthode render.
La méthode render permet d'afficher la vue dans les pages
*/

class PostController extends AbstractController
{
    /* 
    ROUTE permet de diriger sur quelle page le controller fera effets.
    On lui mets un path (un chemin) et un name (post.index).
    */
    #[Route("/post", "post.index")]

    /* 
    Je créer une fonction index qui me retourne une Response qui vient du HttpFoundation du composant Symfony.
    Une Response est un objet qui envoie les info à partir d'une demande.
    */

    // Ce controller sert à afficher les annonces des utilisateurs.

    /* 
    J'utilise le repository, le repository va récupérer toute la récupération de données.
    Donc du-coup j'importe le repository (PostRepository) que je renomme $repository
    */
    /* 
    Pour la pagination, j'importe PaginatorInterface que je renomme $paginator.
    */
    public function index(PostRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        /*  
        Je créer la variable posts puis il appelle $paginator qui vient de PaginatorInterface et celui-ci appelle la méthode paginate.

        */
        $posts = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        /* 
        Je lui retourne la méthode render.
        La méthode render permet d'afficher la vue dans la page post.html.twig.
        */
        return $this->render('pages/post/post.html.twig', [
            /**
             * Je lui passe à la vue une variable 'post, j'appelle le repository est je fais un findAll.
             * FindAll permet de récuperer tout les données dans la base de donnée.
             */
            'post' => $posts
        ]);
    }

    #[Route("/post/nouveau", "post.new")]

    public function new(): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        return $this->render('pages/post/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
