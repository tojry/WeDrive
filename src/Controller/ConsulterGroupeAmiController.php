<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;
use App\Entity\GroupeAmis;


class ConsulterGroupeAmiController extends AbstractController
{
    #[Route('/consultergroupeami/{id}', name: 'app_consulter_groupe_ami')]
    public function index(GroupeAmis $groupeAmi = null): Response
    {
        if($groupeAmi){
            return $this->render('consulter_groupe_ami/index.html.twig', [
                'controller_name' => 'ConsulterGroupeAmiController',
                'groupeAmi' => $groupeAmi
            ]);
        }
    }
}
