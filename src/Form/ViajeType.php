<?php

namespace App\Form;

use App\Entity\Autobus;
use App\Entity\Horario;
use App\Entity\Itinerario;
use App\Entity\Viaje;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('asientos')
            ->add('autobus', EntityType::class, [
                'class' => Autobus::class,
'choice_label' => 'id',
            ])
            ->add('itinerario', EntityType::class, [
                'class' => Itinerario::class,
'choice_label' => 'id',
            ])
            ->add('horario', EntityType::class, [
                'class' => Horario::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Viaje::class,
        ]);
    }
}
