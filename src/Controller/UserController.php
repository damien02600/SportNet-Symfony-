<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends AbstractController
{
    // Ce controlleur sert à modifier un utilisateur à partir de son id
    #[IsGranted('ROLE_USER')]
    #[Route('/utilisateur/edition/{id}', name: 'user.edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

        // Je vérifie si le user il est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        // Je vérifie si le id est le user sont différent alors je les renvoie dans la page post.index
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('post.index');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées'
                );
                return $this->redirectToRoute('post.index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe reseignées est incoreccte'
                );
            }
        }
        return $this->render('pages/user/edit.html.twig', [
            // J'affiche le formulaire
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'user.edit.password')]
    public function editPassword(User $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->getData()['newPassword']
                    )
                );

                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifier'
                );
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('post.index');
            }else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe reseignées est incoreccte'
                );
            }
        }

        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
