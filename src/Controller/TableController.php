<?php

namespace App\Controller;

use App\Entity\Table;
use App\Entity\User;
use App\Form\TableType;
use App\Repository\TableRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TableController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route(path: '/create-table', name: 'create_table')]
    public function create(Request $request, TableRepository $tableRepository, UserRepository $userRepository): Response
    {
        $newTable = new Table();

        $tableForm = $this->createForm(TableType::class, $newTable);

        $tableForm->handleRequest($request);
        if ($tableForm->isSubmitted() && $tableForm->isValid()) {
            /**
             * @var Table $table
             */
            $table = $tableForm->getData();
            /**
             * @var User $user
             */
            $user = $this->getUser();
            $table->setMaster($user);
            $user->addMasterTable($table);
            $tableRepository->save($table, true);
            $userRepository->save($user, true);
            return $this->redirectToRoute('profile', []);
        }


        return $this->render('Table/table.create.html.twig', [
            'form' => $tableForm
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route(path: '/table/{id}', name: 'open_table')]
    public function table(Table $table): Response
    {
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('master', $table);
        if ($user === $table->getMaster()) {
            return $this->render('Table/table.master.twig', [
                'user' => $user
            ]);
        }
    }
}