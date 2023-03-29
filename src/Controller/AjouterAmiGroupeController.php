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

class AjouterAmiGroupeController extends AbstractController
{
    #[Route('/app_ajouter_ami_groupe/{idu}/{idg}', name: 'app_ajouter_ami_groupe')]
    #[ParamConverter('utilisateur', options: ['mapping' => ['id' => 'idu']])] 
    #[ParamConverter('groupe_amis', options: ['mapping' => ['id' => 'idg']])]
    public function index(Utilisateur $idu, GroupeAmis $idg = null,  ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //L'utilisateur est authentifié
        if($idu){
            if($idg){
                $manager = $doctrine->getManager();
                $RAW_QUERY = 'insert ignore into amitie(utilisateur_id,groupe_amis_id) values (:idu , :idg)';
                $statement = $manager->getConnection()->prepare($RAW_QUERY);
                $statement->bindValue(':idu', $idu->getId());
                $statement->bindValue(':idg', $idg->getId());
                $statement->execute();
                $this->addFlash('success',"Ajout utilisateur reussie");
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
