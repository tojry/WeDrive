<?php

namespace App\Tests\Entity;

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
        //--------------------------------zone de test --------------
        $user = new Utilisateur();
        $user->setAdresseMail("abou@toto.fr");
        $user->setMdp("1234");
        $user->setNom("abou");
        $user->setPrenom("kore");
        $user->setSexe("H");
        $user->setVoiture(false);
        $user->setNoTel("12345678");
        $user->setMailNotif("toto@gk.com");



        $this->entityManager->persist($user);
        $this->entityManager->flush();

        print ($user->getId());

        $this->assertEquals("abou@toto.fr",$user->getAdresseMail());
    }
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

?>