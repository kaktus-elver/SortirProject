<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateTimeType::class, array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('dateLimiteInscription', DateTimeType::class, array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('nbInscriptionsMax', IntegerType::class)
            ->add('duree', TimeType::class)
            ->add('infosSortie', TextareaType::class)
            ->add('campus', EntityType::class, array(
                'class' => Campus::class,
                'choice_label' => 'nom'))
            ->add('lieu', EntityType::class, array(
                'class' => Lieu::class,
                'choice_label' => 'nom',
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
