<?php

namespace App\Form;

use App\Entity\Prestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\PrestationOrganization;
use App\Entity\PrestationObject;
use App\Entity\PrestationGauge;

class PrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisation',  EntityType::class, [
                "label" => "Type d'organisation",
                "class" => PrestationOrganization::class,
                "choice_label" => 'description'
            ])
            ->add('object',  EntityType::class, [
                "label" => "Type de prestation",
                "class" => PrestationObject::class,
                "choice_label" => 'description'
            ])
            ->add('gauge',  EntityType::class, [
                "label" => "Jauge de la prestation",
                "class" => PrestationGauge::class,
                "choice_label" => 'description'
            ])
            ->add('startDate', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('endDate', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('email')
            ->add('message')
            // ->add('title')
            // ->add('comment')
            // ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestation::class,
        ]);
    }
}
