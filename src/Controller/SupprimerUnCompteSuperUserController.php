<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;

class SupprimerUnCompteSuperUserController extends AbstractController
{
    #[Route('/supprimeruncomptesuperuser', name: 'app_supprimer_un_compte_super_user')]
    public function index(ManagerRegistry $doctrine, UtilisateurRepository $utilisateurRepository = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 
        $mail =  $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurRepository->rechercher($mail);
        if($utilisateur->getRoles()[0] == "ROLE_USER"){
            return $this->render('supprimer_un_compte_super_user/accesrefuse.html.twig', [
                'controller_name' => 'AfficherListeCompteSuperUserController',
            ]);
        }
        $repository = $doctrine->getRepository(Utilisateur::class);
        $utilisateurs = $repository->findBy(array(), array('adresseMail'=>'asc'));
        $mail =  $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurRepository->rechercher($mail);
        return $this->render('supprimer_un_compte_super_user/index.html.twig', [
            'controller_name' => 'SupprimerUnCompteSuperUserController',
            'utilisateurs' => $utilisateurs,
            'currentuser' => $utilisateur
        ]);
    }

    #[Route('/supprimerCompte/{id}', name: 'utilisateur.supprimerCompte')]
    public function supprimerUnCompteSuperUser(Utilisateur $utilisateur = null, ManagerRegistry $doctrine ) : RedirectResponse {

        // Récuperer la personne
        if($utilisateur){
            // Si la personne existe => le supprimer et retourner un flashMessage de succès
            $manager = $doctrine->getManager();
            // Ajoute la fonction de suppression dans la transaction
            $manager->remove($utilisateur);
            //Exécuter la transation
            $manager->flush();
            $this->addFlash('success','La personne a été supprimer avec succès');
        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash('error','Personne inexistante');
        }
        return $this->redirectToRoute("app_supprimer_un_compte_super_user");
    }
}
