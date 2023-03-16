<?php

namespace App\Controller;

use App\Form\ModifierCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class ModifierSonCompteController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire utilitaire object.
        $this->security = $security;
    }

    #[Route('/modifierSonCompte', name: 'app_modifier_son_compte')]
    public function index( EntityManagerInterface $entityManager, Request $request,): Response
    {

        $user = $this->security->getUser();
        $form = $this->createForm(ModifierCompteType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_consulercompte', array('isSubmit' => 1));
        }

        return $this->render('modifier_son_compte/modifierCompte.html.twig', [
            'user' => $user,
            'controller_name' => 'ModifierSonCompteController',
            'form' => $form->createView(),
        ]);
    }
}

