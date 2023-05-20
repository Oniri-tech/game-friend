<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route(path: '/profile', name: 'profile')]
    public function profile(Security $security)
    {
        $user = $security->getUser();

        return $this->render('Profile/profile.html.twig', [
            'user' => $user,
        ]);
    }
}