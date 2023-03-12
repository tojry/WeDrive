<?php

namespace App\Controller;

use App\Entity\NotifReponse;
use App\Entity\NotifAnnulation;
use App\Entity\NotifTrajetPrive;
use App\Service\NotificationsManager;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotificationsController extends AbstractController {
 
    #[Route('/notifications', name: 'notifications')]
    public function afficher(Request $request, UtilisateurRepository $utilisateurs, NotificationsManager $notifs) : Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();
        $mail =  $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurs->rechercher($mail);
        
        if($utilisateur != null)
        {
            $listeNotifs = $notifs->chargerNotifs($utilisateur);

            return $this->render('notifications.html.twig', [
                'notifs' => $listeNotifs,

            ]);
        }
        else return new Response('Utilisateur actuel non trouvé', 502);

        
    }
}
?>