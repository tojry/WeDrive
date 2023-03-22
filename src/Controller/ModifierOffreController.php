<?php

namespace App\Controller;

use App\Entity\PointIntermediaire;
use App\Entity\Trajet;
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
    public function modifier(Request $request, Trajet $trajet): Response
    {
        $form = $this->createForm(CreerFormType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'offre a bien été modifiée.');

        }

        return $this->render('creer/creer.html.twig', [
            'creer_form' => $form->createView(),
            'trajet' => $trajet,
        ]);
    }

}
