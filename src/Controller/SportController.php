<?php

// Je créer un PostController qui sera le controller de mes post
namespace App\Controller;

use App\Entity\Sports;
use App\Form\PostType;
use App\Form\SportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/* 
Je créer une class PostController qui a le meme nom que mon controller, 
cette class étends AbstractController qui elle contient la méthode render.
La méthode render permet d'afficher la vue dans les pages
*/

class SportController extends AbstractController
{
    #[Route("/sport/nouveau", "sport.new")]

    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $sport = new Sports();
        $form = $this->createForm(SportType::class, $sport);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Je lui dit que mon post est égale au getData
            $sport = $form->getData();

            $manager->persist($sport);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a bien été créer'
            );

            return $this->redirectToRoute('post.new');
        }

        return $this->render('pages/sport/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
