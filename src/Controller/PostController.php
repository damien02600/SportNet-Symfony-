<?php

// Je créer un PostController qui sera le controller de mes post
namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
    #[IsGranted('ROLE_USER')]
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


    // Ce controller permet d'ajouter un post
    #[IsGranted('ROLE_USER')]
    #[Route("/post/nouveau", "post.new")]

    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Je lui dit que mon post est égale au getData
            $post = $form->getData();

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a bien été créer'
            );

            return $this->redirectToRoute('post.index');
        }

        return $this->render('pages/post/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Ce controller sert à modifier une annonce
    #[IsGranted('ROLE_USER')]
    #[Route('/post/edition/{id}', name: 'post.edit', methods: ['GET', 'POST'])]
    public function edit(post $post, Request $request, EntityManagerInterface $manager): Response
    {

                // Vérifier si l'utilisateur actuellement connecté est l'auteur du post
                if ($post->getUser() !== $this->getUser()) {
                    throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier ce post.');
                }

        $form = $this->createForm(PostType::class, $post);
        // Je traite les donnée du formulaire avec handleRequest
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            // persit = commit, flush = push
            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annonce à été modifier avec succées !'
            );

            return  $this->redirectToRoute('post.index');
        }

        return $this->render(
            'pages/post/edit.html.twig',
            [
                // J'affiche le formulaire
                'form' => $form->createView()
            ]
        );
    }

    // Delete Recipe
    #[IsGranted('ROLE_USER')]
    #[Route('/post/suppression/{id}', name: 'post.delete')]
    public function delete(EntityManagerInterface $manager, Post $post): Response
    {

       // Vérifier si l'utilisateur actuellement connecté est l'auteur du post
       if ($post->getUser() !== $this->getUser()) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce post.');
    }

        $manager->remove($post);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre annonce à été supprimer avec succés !'
        );

        return  $this->redirectToRoute('post.index');
    }

    // Affichage en detail du post
    #[Route('/post/show/{id}', name: 'post.show')]
    public function show(Post $post): Response
    {

        return  $this->render('pages/post/show.html.twig', [
            "post" => $post
        ]);
    }
}
