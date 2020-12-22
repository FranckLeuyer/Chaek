<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserCategory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility')
            ->add('firstName')
            ->add('lastName')
            ->add('adressLine1')
            ->add('adressLine2')
            ->add('zipCode')
            ->add('City')
            ->add('country')
            ->add('numCongeSpectacle')
            ->add('numGuso')
            ->add('category',  EntityType::class, [
                "label" => "Catégorie",
                "class" => UserCategory::class,
                "choice_label" => 'title'
            ])
            ->add('email')
            // ->add('isVerified')
            // ->add('roles')
            // ->add('password')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            // ->add('prestations')
            // ->add('calendar')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
