<?php

namespace App\Controller;

use App\Entity\Recherche;
use App\Form\RechercheType;
use App\Repository\TrajetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController {
 
    #[Route('/recherche', name: 'recherche')]
    public function rechercher(Request $request, TrajetRepository $trajets) : Response {

        $recherche = new Recherche();

        $form = $this->createForm(RechercheType::class, $recherche);

        $form->handleRequest($request);
        $res = [];
        $message = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $recherche = $form->getData();

            $res = $trajets->rechercher($recherche);

            if (count($res) === 0) {
                $message .= 'Aucune offre trouvée.';
            }
        }

        return $this->render('recherche.html.twig', [
            'form' => $form->createView(),
            'res' => $res,
            'message' => $message,
        ]);
    }
}
?>