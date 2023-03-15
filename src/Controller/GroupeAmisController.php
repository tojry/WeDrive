<?php

namespace App\Controller;

use App\Entity\GroupeAmis;
use App\Form\CreerGroupeAmisType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeAmisController extends AbstractController
{
    #[Route('/groupe/amis', name: 'app_groupe_amis')]
    public function index(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();
        $mail = $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurs->rechercher($mail);
        if ($utilisateur != null){
            // Création du groupe d'amis
            $groupeAmis = new GroupeAmis();

            // Création du formulaire associé
            $form = $this->createForm(CreerGroupeAmisType::class, $groupeAmis);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $groupeAmis = $form->getData();
                $groupeAmis->addUtilisateur($utilisateur);
                $entityManager->persist($groupeAmis);
                $entityManager->flush();
                return new Response('Groupe "'.$groupeAmis->getNomGroupe().'" créé', 200);
                    //$this->redirectToRoute('/');
                    //
            }

            return $this->render('groupe_amis/index.html.twig', [
                'groupeAmis_form' => $form->createView(),
            ]);
        } else {
            return new Response('Utilisateur actuel non trouvé', 502);
        }
    }
}
