<?php

namespace App\Controller;

use App\Entity\PointIntermediaire;
use App\Entity\Trajet;
use App\Form\CreerFormType;
use App\Repository\UtilisateurRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreerController extends AbstractController {
 
    #[Route('/creer', name: 'creer')]
    public function creer(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager, VilleRepository $villes) : Response { 
        $mail =  $this->getUser()->getUserIdentifier();
        if($mail != null && $mail != ""){
            $utilisateur = $utilisateurs->findOneBy(['adresseMail' => $mail]);
            if(!$utilisateur->isVoiture()){
                return new Response('Vous ne possédez pas de véhicule.', 504);
            }
            $session = $request->getSession();
            if($utilisateur != null && $session != null) {
                $trajet = new Trajet();
                if($trajet != null){
                    $utilisateur->addTrajetPropose($trajet); 
                    $form = $this->createForm(CreerFormType::class, $trajet);

                    $form->handleRequest($request);
                    $res = [];
                    $message = '';

                    if ($form->isSubmitted() && $form->isValid()) {
                        $lieuDepart = $session->get('lieuDepart');
                        $lieuArrive = $session->get('lieuArrive');
                        $pointIntermediaireList = $session->get('pointIntermediaireList');

                        if(isset($lieuArrive) && isset($lieuDepart) && $lieuArrive != "" && $lieuDepart != ""){
                            $lieuDepartVille = $villes->findOneBy(['id' => $lieuDepart]);
                            $lieuArriveVille = $villes->findOneBy(['id' => $lieuArrive]);

                            if($lieuArrive != null && $lieuArrive != null){
                                $trajet->setLieuDepart($lieuDepartVille);
                                $trajet->setLieuArrive($lieuArriveVille);
                                $trajet->newArrayPointIntermediaires();
                                $trajet->setAnnulee(false);
                                
                                if(isset($pointIntermediaireList)) {
                                    foreach($pointIntermediaireList as $idVille){    
                                        $ville = $villes->findOneBy(['id' => $idVille]);
                                        if($ville != null){
                                            $pt = new PointIntermediaire();
                                            $pt->setVille($ville);
                                            $pt->setTrajet($trajet);
                                            $trajet->addPointIntermediaire($pt);
                                        } else return new Response("Ville non trouvée (pointIntermediaire)", 500);
                                    }
                                }
                                // Sauvegarde de l'objet dans la DB   
                                $entityManager->persist($trajet); 
                                $entityManager->flush();

                                // Réponse
                                return $this->redirectToRoute('app_mes_trajets');
                            } else return new Response('Lieu de départ ou d\'arrivée invalide', 501);
                        } else return new Response('Lieu de départ ou d\'arrivé invalide', 501); 
                    } 

                    return $this->render('creer/creer.html.twig', [
                        'creer_form' => $form->createView(),
                        'res' => $res,
                        'message' => $message,
                    ]);

                } else return new Response('Trajet non créée', 502);
            
            } else return new Response('Utilisateur actuel non trouvé', 503);
        }
    }


    #[Route('/Controller/CreerController.php', name: 'preValidationForm', methods: ["POST"])]
    public function preValidationForm(Request $request) : Response {
        if ($request->isXMLHttpRequest()) {  
            $session = $request->getSession();     
            $data = json_decode($request->getContent(), true);

            $session->set('lieuDepart', $data['lieuDepart']);
            $session->set('lieuArrive', $data['lieuArrive']);
            $session->set('pointIntermediaireList', array_values($data['pointIntermediaireList']));

            return new Response("Sauvegardé en session", 200);
        } else return new Response("Ce n'est pas un requête AJAX !", 400);
    }
}
?>