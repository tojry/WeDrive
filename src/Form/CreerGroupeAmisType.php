<?php

namespace App\Form;

use App\Entity\GroupeAmis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class CreerGroupeAmisType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomGroupe', TextType::class,[
                'label'=>'Nom du groupe',
                'required'=>true,
                'constraints'=>[
                    new Length([
                        'min'=>1,
                        'max'=>64
                    ]),
                    new Regex('/^[A-Za-z\s]+$/', "Le nom peut contenir uniquement des lettres !")
                ]
            ])
            ->add('creer', SubmitType::class, [
                'label'=>'Créer le groupe'
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupeAmis::class
        ]);
    }


}
