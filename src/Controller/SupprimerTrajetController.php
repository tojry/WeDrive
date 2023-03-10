<?php

namespace App\Controller;

use App\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TrajetRepository;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isEmpty;

class SupprimerTrajetController extends AbstractController
{
    #[Route('/trajet/{id}/supprimer', name: 'supprimerTrajet')]
    public function supprimerTrajet(Request $request, TrajetRepository $trajet) : Response {

    }
}
