<?php
// src/Form/PortfolioAssetType.php

namespace App\Form;

use App\Entity\PortfolioAsset;
use App\Entity\Asset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortfolioAssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('asset', EntityType::class, [
                'class' => Asset::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un asset',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PortfolioAsset::class,
        ]);
    }
}