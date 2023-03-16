<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsulercompteController extends AbstractController
{

    #[Route('/consulercompte/{isSubmit}', name: 'app_consulercompte',  requirements: ['page' => '\d+'])]
    public function index(EntityManagerInterface $entityManager,Request $request, int $isSubmit = 0): Response
    {

        $routeParameters = $request->attributes->get('_route_params');
        //il faut transposer ca dans le twig, j'ai pas la syntaxe
        if ($routeParameters['isSubmit'] == 1) {
            print "Formulaire mise a jour";
        }

        $user = $this->getUser();
        if ($user) {
            //  $id = $user->getId();
            //     $adresseMail = $user->getAdresseMail();
            //    $mdp = $user->getMdp();
            //   $nom = $user->getNom();
            // $prenom = $user->getPrenom();
            $sexe = $user->getSexe();
            $isVoiture = $user->isVoiture();
         //   $noTel = $user->getNoTel();
            $isMailNotif = $user->isMailNotif();
            if ($isVoiture) {
                $voiture = 'oui';
            } else {
                $voiture = 'non';
            }
            if ($isMailNotif) {
                $notif = 'oui';
            } else {

                $notif = 'non';
            }

        } else {
            // L'utilisateur n'est pas connecté
            echo "Vous n'êtes pas connecté";
        }

        return $this->render('consulercompte/index.html.twig', [
            'user' => $user,
            'voiture' => $voiture,
            'notif' => $notif,

        ]);
    }
}
