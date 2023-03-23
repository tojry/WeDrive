<?php

namespace App\Form;

use App\Entity\Trajet;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuDepart', TextType::class, ['label' => 'Lieu de départ* : ', 'mapped' => false, 'required' => false])
            ->add('ptIntermediaire', TextType::class, ['label' => 'Point intermédiaire : ', 'mapped' => false, 'required' => false])
            ->add('addPtIntermediaire', ButtonType::class, ['label' => '+'])
            ->add('rmPtIntermediaire', ButtonType::class, ['label' => '-'])
            ->add('lieuArrive', TextType::class, ['label' => 'Lieu d\'arrivée* : ', 'mapped' => false, 'required' => false])
            ->add('dateHeureDepart', DateTimeType::class, ['label' => 'Date de départ* : ', 'widget' => 'single_text',])
            ->add('precisionLieuRdv', TextareaType::class, ['label' => 'Lieu du rendez-vous* : '])
            ->add('prix', IntegerType::class, ['label' => 'Prix du trajet* : ',
            'attr' => ['min' => "1"]])
            ->add('commentaire', TextareaType::class, ['label' => 'Commentaires : ', 'required' => false])
            ->add('capaciteMax', IntegerType::class, ['label' => 'Nombre de places disponibles* : ',
            'attr' => ['min' => "1"]])

            ->add('annuler', ResetType::class, ['label' => 'Annuler'])
            ->add('creer', SubmitType::class, ['label' => 'Soumettre'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
