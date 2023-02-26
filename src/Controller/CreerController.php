<?php

namespace App\Controller;

use App\Entity\PointIntermediaire;
use App\Entity\Trajet;
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

class CreerController extends AbstractController {

    private Trajet $trajet;
 
    #[Route('/creer', name: 'creer')]
    public function creer(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager) : Response {

        $this->trajet = new Trajet();

        $session = $request->getSession();
        $uId = "1"; //$session->get('user-id');
        $res = $utilisateurs->rechercher($uId);
        
        if(count($res) === 1)
        {
            $this->trajet->setCovoitureur(array_values($res)[0]); 
            $form = $this->createForm(CreerFormType::class, $this->trajet);

            $form->handleRequest($request);
            $res = [];
            $message = '';

            if ($form->isSubmitted() && $form->isValid()) {
                // Sauvegarde de l'objet dans la DB
                $entityManager->persist($this->trajet); 
                $entityManager->flush();

                // Réponse
                return new Response('Trajet ' . $this->trajet->getId() . ' crée');
            }

            return $this->render('creer/creer.html.twig', [
                'creer_form' => $form->createView(),
                'res' => $res,
                'message' => $message,
            ]);
        }
        else
        {
            return new Response('Utilisateur actuel non trouvé');
        }
        
    }


    #[Route('/Controller', name: 'creerPointIntermediaire', methods: ["POST"])]
    public function ajouterPointIntermediaire(Request $request, VilleRepository $villes, PointIntermediaireRepository $points) : Response {
        
        if ($request->isXMLHttpRequest()) {       
            $data = json_decode($request->getContent(), true);

            $res = $villes->rechercher($data['texte']);

            if(count($res) === 1)
            {
                $pt = new PointIntermediaire();
                $points->ajouterPointIntermediaire($pt);
                $pt->setVille(array_values($res)[0]);
                $pt->setTrajet($this->trajet);
                $this->trajet->addPointIntermediaire($pt);
                return new Response("Point intermédiaire ajouté.");
            }
            return new Response("Ville non trouvée.");
        }
    
        return new Response("Ce n'est pas un requête AJAX !", 400);
    }
}
?>