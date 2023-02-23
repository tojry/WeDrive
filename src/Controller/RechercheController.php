<?php

namespace App\Controller;

use App\Entity\Recherche;
use App\Form\RechercheType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController {
 
    #[Route('/recherche')]
    public function rechercher(Request $request) : Response {

        $recherche = new Recherche();

        $form = $this->createForm(RechercheType::class, $recherche);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recherche = $form->getData();


            return $this->redirectToRoute($request->attributes->get('_route'));
        }

        return $this->render('recherche.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
?>