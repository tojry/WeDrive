<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseMail',EmailType::class,['required' => true])
            ->add('mdp',PasswordType::class,['required' => true])
            ->add('nom',TextType::class,['required' => true])
            ->add('prenom',TextType::class,['required' => true])
            ->add('sexe',ChoiceType::class, [
                'choices'  => [
                    'Homme' => 'H',
                    'Femme' => 'F',
                    'Autres/LGBT++' => "Z",
                ]])
            ->add('voiture',CheckboxType::class,['required' => false])
            ->add('noTel',IntegerType::class ,['required' => true])
            ->add('mailNotif',CheckboxType::class,['required' => false])
            ->add('annuler', ResetType::class, ['label' => 'Effacer'])
            ->add('creer', SubmitType::class, ['label' => 'S\'inscrire'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
?>