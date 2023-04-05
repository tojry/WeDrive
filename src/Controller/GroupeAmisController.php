<?php

namespace App\Controller;

use App\Entity\GroupeAmis;
use App\Form\CreerGroupeAmisType;
use App\Repository\GroupeAmisRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeAmisController extends AbstractController
{
    #[Route('/amis/creation', name: 'creation_amis')]
    public function index(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager, GroupeAmisRepository $groupes): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mail = $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurs->rechercher($mail);
        if ($utilisateur != null){
            // Création du groupe d'amis
            $groupeAmis = new GroupeAmis();

            // Création du formulaire associé
            $form = $this->createForm(CreerGroupeAmisType::class, $groupeAmis);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $groupeAmis->setCreateur($utilisateur);
                $existingGroup = $groupes->findOneBy([
                    'nomGroupe' => $groupeAmis->getNomGroupe(),
                    'createur' => $groupeAmis->getCreateur(),
                ]);
                if ($existingGroup) {
                    $this->addFlash('danger', 'Un groupe avec le même nom et le même créateur existe déjà.');
                } else {
                    //
                    $groupeAmis->addUtilisateur($utilisateur);
                    // Ajout à l'utilisateur son groupe créé
                    $utilisateur->addGroupeCree($groupeAmis);
                    $entityManager->persist($groupeAmis);
                    $entityManager->flush();
                    return $this->redirectToRoute("app_consulter_groupe_ami", ['id' => $groupeAmis->getId()]);
                }
            }

            return $this->render('groupe_amis/index.html.twig', [
                'groupeAmis_form' => $form->createView(),
            ]);
        } else {
            return new Response('Utilisateur actuel non trouvé', 502);
        }
    }
}