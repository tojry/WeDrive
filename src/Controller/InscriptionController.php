<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();

        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);
        $message = '';

        if ($form->isSubmitted() && $form->isValid()) {

            // hash the password (based on the security.yaml config for the $user class)
            $motdePasseSaisi = $utilisateur->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $motdePasseSaisi
            );
            $utilisateur->setMdp($hashedPassword);


            $entityManager->persist($utilisateur);
            $entityManager->flush();


            // Réponse
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/inscription.html.twig', [
            'inscription_form' => $form->createView(),
        ]);
    }
}

?>