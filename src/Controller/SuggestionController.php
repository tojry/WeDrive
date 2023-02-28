<?php

namespace App\Controller;

use App\Entity\PointIntermediaire;
use App\Entity\Trajet;
use App\Entity\Ville;
use App\Entity\Utilisateur;
use App\Form\CreerFormType;
use App\Repository\PointIntermediaireRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuggestionController extends AbstractController
{
    #[Route('/suggestion', name: 'app_suggestion')]
    public function index(): Response
    {
        return $this->render('suggestion/index.html.twig', [
            'controller_name' => 'SuggestionController',
        ]);
    }

    #[Route('/Controller/SuggestionController.php', name: 'rechercherVille', methods: ["POST"])]
    public function rechercherVille(Request $request, VilleRepository $villes) : Response {
        
        if ($request->isXMLHttpRequest()) {       
            $data = json_decode($request->getContent(), true);
            $res = $villes->rechercher($data['texte']);


            if($res != null && count($res) > 0)
            {
                $response = "";
                foreach ($res as $ville){
                    $response .= '<div class="autocomplete-items" id="'.($ville->getId()).'">'.($ville->getVille()).' '.'('.($ville->getCodePostal()).')</div>';
                }
                return new Response($response, 200);
            }

            return new Response("Aucune ville trouvée.", 300);
        }
    
        return new Response("Ce n'est pas un requête AJAX !", 400);
    }
}