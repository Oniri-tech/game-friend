<?php

namespace App\Controller;

use App\Entity\User;
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
        /**
         * @var User $user
         */
        $user = $security->getUser();
        $master = $user->getMasterTables();
        $tables = $user->getGameTables();

        return $this->render('Profile/profile.html.twig', [
            'user' => $user,
            'masterTables' => $master,
            'tables' => $tables
        ]);
    }
}