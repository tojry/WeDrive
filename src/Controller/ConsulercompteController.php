<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsulercompteController extends AbstractController
{
    #[Route('/consulercompte', name: 'app_consulercompte')]
    public function consultercompte(): Response
    {
        $user = $this->getUser();
        if ($user) {
            $id = $user->getId();
            $adresseMail = $user->getAdresseMail();
            $mdp = $user->getMdp();
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
            echo "Vous n'êtes pas connecté";
        }
        return $this->render('consulercompte/index.html.twig',  [
            'user' => $user,
             'voiture' => $voiture,
             'notif' => $notif,
        ]);
    }
}
