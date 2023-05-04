<?php

// Je crée un controller grace à la commande php bin/console make:controller SecurityController
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    // Controller connexion
    #[Route('/connexion', name: 'security.login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }



    // Controller deconexion
    #[Route('/deconexion', name: 'security.logout')]
    public function logout()
    {
        // nothing to do here
    }
}
