<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PrestationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $users = $options['prestaUsers'];

        $choices = [];
        foreach ($options['prestaUsers'] as $user){
            $choices[$user['firstName'] . " " . $user['lastName']] = $user['id'];
        }

        $builder
            ->add('intervenant', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'label' => 'Intervenants',
                'choices' => $choices,
                'data' => [8,7]
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    "class" => "btn btn-danger"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
        $resolver->setRequired('prestaUsers');
    }
}
