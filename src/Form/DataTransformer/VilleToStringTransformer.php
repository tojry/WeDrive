<?php
namespace App\Form\DataTransformer;

use App\Entity\Issue;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class VilleToStringTransformer implements DataTransformerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function transform($ville): string
    {
        if ($ville == null) {
            return '';
        }

        return $ville->getId();
    }

    public function reverseTransform($villeInput): ?Ville
    {
        if (!$villeInput) {
            return null;
        }

        preg_match("/([a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?(?:[- '][a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?)*)/i", $villeInput, $match_ville);
        preg_match('/([0-9]{1,5})/', $villeInput, $match_postal);

        $ville = $this->entityManager
            ->getRepository(Ville::class)
            // query for the issue with this id
            ->findOneBy([
                'ville' => $match_ville,
                'code_postal' => $match_postal,
            ]);
        ;

        if ($ville === null) {
            throw new TransformationFailedException(sprintf(
                'Aucune ville correspondant n\'a été trouvée ',
                $villeInput
            ));
        }

        return $ville;
    }
}
?>