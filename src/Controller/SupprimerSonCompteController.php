<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;


class SupprimerSonCompteController extends AbstractController
{
    #[Route('/supprimersoncompte', name: 'app_supprimer_son_compte')]
    public function index(UtilisateurRepository $utilisateurRepository = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //L'utilisateur est authentifié
        return $this->render('supprimer_son_compte/index.html.twig', [
            'controller_name' => 'SupprimerSonCompteController'
        ]);
    }

    #[Route('/supprimerSonComptePerso/{pwd}', name: 'utilisateur.supprimerComptePerso')]
    public function supprimerSonComptePerso(?string $pwd = null,UtilisateurRepository $utilisateurRepository = null, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher) : RedirectResponse {
        
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //L'utilisateur est authentifié
        
            $mail =  $this->getUser()->getUserIdentifier();
            $utilisateur = $utilisateurRepository->rechercher($mail);
            if($utilisateur){
                if(($utilisateur->getTrajets()->isEmpty())){
                    if(($utilisateur->getTrajetProposes()->isEmpty())){
                        //verifier mot de passe 
                        if($pwd == null || $pwd = '0'){
                            $this->addFlash('error',"Veuillez entrer votre mot de passe afin de confirmer la suppression de votre compte");
                        }
                        else{
                            $hashedPassword = $passwordHasher->hashPassword(  $utilisateur, $pwd );
                            if(strcmp($utilisateur->getPassword(), $hashedPassword) != 0){
                                $this->container->get('security.token_storage')->setToken(null);
                                $manager = $doctrine->getManager();
                                $manager->remove($utilisateur);
                                $manager->flush();
                                return $this->redirectToRoute("app_logout");
                            }
                            else{
                                $this->addFlash('error',"mot de passe incorrecte");
                            }           
                        }
                    }else{
                        $this->addFlash('error','Suppression impossible : vous avez déposer une demande de covoiturage encore en cours de validité');
                    }
                }
                else{
                    $this->addFlash('error','Suppression impossible : vous participer encore à un trajet');
                }
            } else {
                $this->addFlash('error','Personne inexistante');
            }
        return $this->redirectToRoute("app_supprimer_son_compte");
    }
}
