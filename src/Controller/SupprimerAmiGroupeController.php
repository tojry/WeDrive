<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use App\Entity\GroupeAmis;


class SupprimerAmiGroupeController extends AbstractController
{
    #[Route('/app_supprimer_ami_groupe/{idu}/{idg}', name: 'app_supprimer_ami_groupe')]
    #[ParamConverter('utilisateur', options: ['mapping' => ['id' => 'idu']])] 
    #[ParamConverter('groupe_amis', options: ['mapping' => ['id' => 'idg']])]
    public function index(Utilisateur $idu, GroupeAmis $idg = null,  ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //L'utilisateur est authentifié
        if($idu){
            if($idg){
                $manager = $doctrine->getManager();
                $RAW_QUERY = 'delete from amitie where utilisateur_id = :idu and groupe_amis_id = :idg';
                $statement = $manager->getConnection()->prepare($RAW_QUERY);
                $statement->bindValue(':idu', $idu->getId());
                $statement->bindValue(':idg', $idg->getId());
                $statement->execute();
                $this->addFlash('success',"Suppression reussie");
            }
            else{
                $this->addFlash('error',"Le groupe renseigné est inexistant");
            }
        }
        else{
            $this->addFlash('error',"L'utilisateur renseigné est inexistant");
        }
        return $this->redirectToRoute("app_consulter_groupe_ami", ['id' => $idg->getId()]);
    }
}
