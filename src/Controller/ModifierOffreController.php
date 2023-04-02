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
    public function modifier(Request $request, PointIntermediaire $pointIntermediaire, Trajet $trajet, EntityManagerInterface $entityManager, VilleRepository $villes): Response
    {

        $form = $this->createForm(CreerFormType::class, $trajet);
        $form->handleRequest($request);
        $session = $request->getSession();
        if ($form->isSubmitted() && $form->isValid() ) {
            if ($session != null) {
                // Vérifier si les informations sont différentes

                $valdep = $form['lieuDepart']->getData();
                $valArr = $form['lieuArrive']->getData();
                $pointIntermediaireList = $session->get('pointIntermediaireList');

                $villeDep = $villes->rechercher($valdep);
                $villeArr = $villes->rechercher($valArr);

                if ($villeDep != null) {
                    $trajet->setLieuDepart($villeDep[0]);
                }
                if ($villeArr != null) {

                    $trajet->setLieuArrive($villeArr[0]);
                }

                if (isset($pointIntermediaireList)) {
                    foreach ($pointIntermediaireList as $idVille) {
                        $ville = $villes->findOneBy(['id' => $idVille]);
                        if ($ville != null) {
                            $pt = new PointIntermediaire();
                            $pt->setVille($ville);
                            $pt->setTrajet($trajet);
                            $trajet->addPointIntermediaire($pt);
                        } else return new Response("Ville non trouvée (pointIntermediaire)", 500);
                    }
                }

                // Enregistrer les modifications
                $entityManager->persist($trajet);
                $entityManager->flush();
                $this->addFlash('success', 'L\'offre a bien été modifiée.');
            } else {
                $this->addFlash('warning', 'Aucune modification n\'a été enregistrée.');
            }
        }


        return $this->render('modifier_offre/index.html.twig', [
            'creer_form' => $form->createView(),
            'trajet' => $trajet,
        ]);
    }
}