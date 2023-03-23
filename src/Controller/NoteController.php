<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Repository\EvaluationRepository;
use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends AbstractController
{
    #[Route('/Controller/NoteController.php', name: 'noteUtilisateur', methods: ["POST"])]
    public function noteUtilisateur(Request $request, EvaluationRepository $evaluations ,UtilisateurRepository $utilisateurs, TrajetRepository $trajets, EntityManagerInterface $entityManager) : Response {
        if ($request->isXMLHttpRequest()) {      
            $data = json_decode($request->getContent(), true);

            if($data['idEvaluateur'] != "" && $data['idEvalue'] != "" && $data['idTrajet'] != "" && $data['note'] != ""){
                
                $eval = $evaluations->findOneBy(['idTrajet' => $data['idTrajet'], 'idEvalue' => $data['idEvalue'], 'idEvaluateur' => $data['idEvaluateur']]);
                
                if($eval == null){
                    $evaluateur = $utilisateurs->findOneBy(['id' => $data['idEvaluateur']]);
                    $evalue = $utilisateurs->findOneBy(['id' => $data['idEvalue']]);
                    $trajet = $trajets->findOneBy(['id' => $data['idTrajet']]);

                    if($evaluateur != null && $evalue != null && $trajet != null){                    
                        $eval = new Evaluation();
                    
                        $eval->setIdEvaluateur($evaluateur);
                        $eval->setIdEvalue($evalue);
                        $eval->setIdTrajet($trajet);

                        $eval->setNote((int)$data['note']);

                        $entityManager->persist($eval);
                        $entityManager->flush();

                    } else return new Response("Utilisateur ou trajet non trouvé", 500);
                }
                else{
                    $eval->setNote((int)$data['note']);
                    $entityManager->persist($eval);
                    $entityManager->flush();
                }
                return new Response("Utilisateur noté", 200);
            } else  return new Response("Erreur dans la transmission de donnée AJAX/PHP", 501);
           
        } else return new Response("Ce n'est pas un requête AJAX !", 400);
    }
}
