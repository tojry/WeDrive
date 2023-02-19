<?php

namespace App\Tests;

use App\Entity\Trajet;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testUtilisateur()
    {
        //--------------------------------zone de test et exemple--------------
        $user = new Utilisateur();
        $user->setAdresseMail("abou@toto.fr");
        $user->setMdp("1234");
        $user->setNom("abou");
        $user->setPrenom("kore");
        $user->setSexe("H");
        $user->setVoiture(false);
        $user->setNoTel("12345678");
        $user->setMailNotif("toto@gk.com");

        $trajet = new Trajet();
        $trajet->setLieuDepart("Nancy");
        $trajet->setLieuArrive("Paris");
        $trajet->setDateHeureDepart(new \DateTime('now'));
        $trajet->setPrix(40);
        $trajet->setCapaciteMax(5);
        $trajet->setPrecisionLieuRdv("ok");
        $trajet->setCommentaire("ok");
        $trajet->setCovoitureur($user);

        $this->entityManager->persist($user);
        $this->entityManager->persist($trajet);
        $this->entityManager->flush();


        $this->assertEquals("abou@toto.fr", $user->getAdresseMail());
        $this->assertEquals($user->getId(),$trajet->getCovoitureur()->getId());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

?>