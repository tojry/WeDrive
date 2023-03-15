<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;

class ConsulercompteController extends AbstractController
{
    #[Route('/consulercompte', name: 'app_consulercompte')]
    public function consultercompte(UtilisateurRepository  $utilisateurRepository): Response
    {
        $listUsers = $utilisateurRepository->findAll();
        $user = $this->getUser();
        if ($user) {
            $id = $user->getId();
            $adresseMail = $user->getAdresseMail();
            $nom = $user->getNom();
            $prenom = $user->getPrenom();
            $sexe = $user->getSexe();
            $isVoiture = $user->isVoiture();
            $noTel = $user->getNoTel();
            $isMailNotif = $user->isMailNotif();
            if($isVoiture){
                $voiture = 'oui';
            }
            else{
                $voiture = 'non';
            }
            if($isMailNotif){
                $notif = 'oui';
            }
            else{
                $notif = 'non';
            }

        } else {
            // L'utilisateur n'est pas connecté

            return new Response("Vous n'êtes pas connecté",502);
        }
        return $this->render('consulercompte/index.html.twig',  [
            'user_co' => $user,
             'voiture' => $voiture,
             'notif' => $notif,
            'listusers'=> $listUsers,
        ]);
    }
}
