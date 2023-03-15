<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom*', 'required' => true])
            ->add('prenom', TextType::class, ['label' => 'Prénom*', 'required' => true])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe*',
                'choices' => [
                    'Homme' => 'H',
                    'Femme' => 'F',
                ]])->add('voiture')
            ->add('noTel', TextType::class, ['label' => 'Numéro de téléphone*', 'required' => true])
            ->add('voiture', CheckboxType::class, ['label' => 'J\'ai un véhicule à ma disposition :', 'required' => false])
            ->add('mailNotif', CheckboxType::class, ['label' => 'J\'accepte de recevoir des notifications par mail de la part de WeDrive :', 'required' => false])
            ->add('creer', SubmitType::class, ['label' => 'Modifier'])
            ->add('supprimer', SubmitType::class, ['label' => 'Supprimer', 'attr' => [ 'class' => 'is-danger', 'onclick' => 'suppresionCompte()' ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
