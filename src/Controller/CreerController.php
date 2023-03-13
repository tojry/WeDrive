<?php

namespace App\Controller;

use App\Entity\PointIntermediaire;
use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use App\Form\CreerFormType;
use App\Repository\UtilisateurRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreerController extends AbstractController {
 
    #[Route('/creer', name: 'creer')]
    public function creer(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager) : Response { 
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();
        $mail =  $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurs->rechercher($mail);
        
        if($utilisateur != null)
        {
            $trajet = $session->get('trajet', new Trajet());
            if($trajet != null)
            {
                $trajet->setCovoitureur($utilisateur); 
                $trajet->addUtilisateur($utilisateur);
                $form = $this->createForm(CreerFormType::class, $trajet);
                $session->set('trajet', $trajet);

                $form->handleRequest($request);
                $res = [];
                $message = '';

                if ($form->isSubmitted() && $form->isValid()) {

                    // Persist sur tous les nouveaux points
                    foreach($trajet->getPointIntermediaires() as $point)
                        $entityManager->persist($point); 

                    // Sauvegarde de l'objet dans la DB
                    $entityManager->persist($trajet); 
                    $entityManager->flush();

                    // Réponse
                    return new Response('Trajet ' . $trajet->getId() . ' crée', 200);
                }

                return $this->render('creer/creer.html.twig', [
                    'creer_form' => $form->createView(),
                    'res' => $res,
                    'message' => $message,
                ]);
            } else return new Response('Trajet non récupéré/crée', 503);
        }
        else return new Response('Utilisateur actuel non trouvé', 502);
        
    }


    #[Route('/Controller/CreerController.php', name: 'preValidationForm', methods: ["POST"])]
    public function preValidationForm(Request $request, VilleRepository $villes, EntityManagerInterface $entityManager) : Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($request->isXMLHttpRequest()) {       
            $data = json_decode($request->getContent(), true);

            $lieuDepart = $villes->getByID($data['lieuDepart']);
            $lieuArrive = $villes->getByID($data['lieuArrive']);
            $pointIntermediaireList = array_values($data['pointIntermediaireList']);

            $session = $request->getSession();
            if($session != null && $lieuArrive != null && $lieuDepart != null)
            {
                $trajet = $session->get('trajet');
                if($trajet != null)
                {
                    $trajet->setLieuDepart($lieuDepart);
                    $trajet->newArrayPointIntermediaires();
                    $i = 0;
                    foreach($pointIntermediaireList as $idVille){    

                        $ville = $villes->getByID($idVille);
                        if($ville != null){
                            $pt = new PointIntermediaire();
                            $pt->setVille($ville);
                            $pt->setTrajet($trajet);
                            $trajet->addPointIntermediaire($pt);
                        } else return new Response("Ville non trouvée (pointIntermediaire)", 500);
                    }
                    $trajet->setLieuArrive($lieuArrive);
                    $session->set('trajet', $trajet);

                    return new Response("Tout s'est bien passé.", 200);
                }
            }
            else return new Response("Ville non trouvée (lieuDepart ou lieuArrive)", 501);
        }
        return new Response("Ce n'est pas un requête AJAX !", 400);
    }
}
?>