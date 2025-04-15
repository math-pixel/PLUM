<?php

namespace App\Form;

use App\Entity\Asset;
use App\Entity\Portfolio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
//            ->add('assets', EntityType::class, [
//                'class' => Asset::class,
//                'choice_label' => 'id',
//                'multiple' => true,
//            ])
//            ->add('parent', EntityType::class, [
//                'class' => Portfolio::class,
//                'choice_label' => 'name', // ou un autre attribut pertinent
//                'required' => false,      // car il peut être facultatif
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portfolio::class,
        ]);
    }
}
