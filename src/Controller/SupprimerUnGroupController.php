<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use App\Repository\GroupeAmisRepository;

class SupprimerUnGroupController extends AbstractController
{
    /*
    #[Route('/supprimer/un/group', name: 'app_supprimer_un_group')]
    public function index(): Response
    {
        return $this->render('supprimer_un_group/index.html.twig', [
            'controller_name' => 'SupprimerUnGroupController',
        ]);
    }*/

    #[Route('/supprimer-groupe/{id}', name: 'app_supprimer_groupe')]
    public function supprimer(int $id, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository, GroupeAmisRepository $groupeAmisRepository, OffreRepository $offreRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mail = $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurRepository->rechercher($mail);
        $groupeAmis = $groupeAmisRepository->find($id);
    
        if (!$groupeAmis) {
            $this->addFlash('danger', 'Le groupe demandé n\'existe pas.');
            return $this->redirectToRoute('app_consulter_groupes');
        }
    
        $offres = $offreRepository->findBy(['groupeAmis' => $groupeAmis]);
    
        if (count($offres) > 0) {
            $this->addFlash('danger', 'Le groupe ne peut pas être supprimé car il contient des offres de trajet.');
            return $this->redirectToRoute('app_consulter_groupes');
        }
    
        if ($utilisateur && $groupeAmis && $groupeAmis->getCreateur() === $utilisateur) {
            // Supprimer le groupe pour tous les membres
            foreach ($groupeAmis->getUtilisateurs() as $membre) {
                $membre->removeAmi($groupeAmis);
                $entityManager->persist($membre);
            }
    
            // Supprimer le groupe
            $entityManager->remove($groupeAmis);
            $entityManager->flush();
    
            $this->addFlash('success', 'Le groupe a été supprimé.');
        } else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à supprimer ce groupe.');
        }
    
        return $this->redirectToRoute('app_consulter_groupes');
    }
}
