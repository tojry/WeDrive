<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;

class ConsultercompteController extends AbstractController
{
    #[Route('/consultercompte/{id}',name: 'app_consultercompte')]
    public function consultercompte( Utilisateur $utilisateur): Response
    {

        $user = $utilisateur;
        if ($user) {

            $isVoiture = $user->isVoiture();

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
        return $this->render('consultercompte/index.html.twig',  [
            'user_co' => $this->getUser(),
            'user'=>$user,
             'voiture' => $voiture,
             'notif' => $notif,

        ]);
    }
}
