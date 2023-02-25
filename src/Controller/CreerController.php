<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Form\CreerFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotNull;

class CreerController extends AbstractController {
 
    #[Route('/creer', name: 'creer')]
    public function creer(Request $request, UtilisateurRepository $utilisateurs, EntityManagerInterface $entityManager) : Response {

        $trajet = new Trajet();

        $session = $request->getSession();
        $uId = "1"; //$session->get('user-id');
        $res = $utilisateurs->rechercher($uId);
        
        if(count($res) === 1)
        {
            $trajet->setCovoitureur(array_values($res)[0]); 
            $form = $this->createForm(CreerFormType::class, $trajet);

            $form->handleRequest($request);
            $res = [];
            $message = '';

            if ($form->isSubmitted() && $form->isValid()) {
                // Sauvegarde de l'objet dans la DB
                $entityManager->persist($trajet); 
                $entityManager->flush();

                // Réponse
                return new Response('Trajet ' . $trajet->getId() . ' crée');
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
}
?>