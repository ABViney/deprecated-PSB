<?php

namespace App\Form;

use App\Entity\ESRPartUsed;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ESRPartUsedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('esr_part', ESRPartType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'empty_data' => '0',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ESRPartUsed::class,
        ]);
    }
}
