<?php

namespace App\Form;

use App\Form\DataTransformer\VilleToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheType extends AbstractType
{
    private $transformer;

    public function __construct(VilleToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuDepart', TextType::class, [
                'label' => 'Départ',
                'required' => false,
            ])
            ->add('lieuArrivee', TextType::class, [
                'label' => 'Arrivée',
                'required' => false,
            ])
            ->add('dateDepart', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('rechercher', SubmitType::class)
        ;

        $builder->get('lieuDepart')
                ->addModelTransformer($this->transformer);
        $builder->get('lieuArrivee')
                ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
