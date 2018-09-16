<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        /**
         * Login method.
         * Generates error text if she occured,
         * otherwise authorizes the user.
         */
    	$error = $utils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        /**
         * Logout method, works without additional code in his body.
         */
    }
}
