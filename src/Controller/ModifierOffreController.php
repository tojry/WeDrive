<?php

namespace App\Controller;

use App\Entity\PointIntermediaire;
use App\Entity\Trajet;
use App\Entity\Ville;
use App\Form\CreerFormType;
use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierOffreController extends AbstractController
{
    #[Route('/modifierOffre/{id}', name: 'app_modifier_offre')]
    public function modifier(Request $request, Trajet $trajet, EntityManagerInterface $entityManager, VilleRepository $villes): Response
    {

        $form = $this->createForm(CreerFormType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si les informations sont différentes
            $formValues = $form->getData();
            $valdep = $form['lieuDepart']->getData();
            $valArr= $form['lieuArrive']->getData();
            $villeArr = $villes->rechercher($valArr);

            $villeDep = $villes->rechercher($valdep);
            $villeArr = $villes->rechercher($valArr);
            //echo $valdep;
            if($villeDep != null){
                echo $villeDep[0];

                $trajet->setLieuDepart($villeDep[0]);
            }
            if($villeArr != null){
                echo $villeArr[0];

                $trajet->setLieuArrive($villeArr[0]);
            }


            echo"ici";
            // Enregistrer les modifications
            $entityManager->persist($trajet);
            $entityManager->flush();
            $this->addFlash('success', 'L\'offre a bien été modifiée.');
        } else {
            $this->addFlash('warning', 'Aucune modification n\'a été enregistrée.');
            }


        return $this->render('modifier_offre/index.html.twig', [
            'creer_form' => $form->createView(),
            'trajet' => $trajet,
        ]);
    }
}