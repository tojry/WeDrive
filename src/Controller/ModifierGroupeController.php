<?php

namespace App\Controller;

use App\Form\ModifierGroupeType;
use App\Repository\GroupeAmisRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierGroupeController extends AbstractController
{
    #[Route('/modifier/groupe/{id}', name: 'app_modifier_groupe')]
    public function index(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager, GroupeAmisRepository $groupes, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mail = $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurs->rechercher($mail);
        if ($utilisateur!=null){
            $groupe = $groupes->find($id);
            if (!$groupe){
                return new Response("Groupe d'amis non trouvé", 501);
            }
            $nom_groupe = $groupe->getNomGroupe();
            $form = $this->createForm(ModifierGroupeType::class, $groupe);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $existingGroup = $groupes->findOneBy([
                    'nomGroupe' => $groupe->getNomGroupe(),
                    'createur' => $groupe->getCreateur(),
                ]);
                if ($nom_groupe==$groupe->getNomGroupe()){
                    $this->addFlash('danger', 'Le nom du groupe est déjà "'.$nom_groupe.'" !');
                }else if ($existingGroup) {
                    $this->addFlash('danger', 'Un groupe avec le même nom et le même créateur existe déjà.');
                } else {
                    $entityManager->persist($groupe);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_home');
                }
            }

            return $this->render('modifier_groupe/index.html.twig', [
               'modifierGroupe_form'=>$form->createView()
            ]);

        }
        return $this->render('modifier_groupe/index.html.twig', [
            'controller_name' => 'ModifierGroupeController',
        ]);
    }
}
