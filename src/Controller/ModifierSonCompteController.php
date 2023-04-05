<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ModifierCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ModifierSonCompteController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire utilitaire object.
        $this->security = $security;
    }

    #[Route('/modifierSonCompte/{id}', name: 'app_modifier_son_compte')]
    public function index(Request $request, Utilisateur $user, EntityManagerInterface $entityManager): Response
    {

        $user_co = $this->getUser();

        if($user_co != $user){
            return new Response("Vous n'avez pas accès à cette page");
        }

        $form = $this->createForm(ModifierCompteType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_consultercompte', ['id' => $user->getId()]);
        }

        return $this->render('modifier_son_compte/modifierCompte.html.twig', [
            'user' => $user,
            'controller_name' => 'ModifierSonCompteController',
            'form' => $form->createView(),
        ]);
    }
}

