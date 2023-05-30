<?php

namespace App\Form;

use App\Entity\ESRPart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ESRPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('part_no', TextType::class, [
                'label' => 'Part No.',
                'required' => $options['required'],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'empty_data' => '',
                // 'required' => false
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'currency' => 'USD',
                'divisor' => 100,
                'empty_data' => '0.00',
                // Default validation permits any floating point
                'attr' => ['pattern' => '^\d+(\.\d{2})?$'],
                'required' => $options['required'],
            ])
        ;
        // $builder->get('price')
        //     ->addViewTransformer(new CallbackTransformer(
        //         static fn ($price): string => number_format(intval($price)/100, 2),
        //         static fn ($price): int => dump($price)
        //     ))
        // ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ESRPart::class,
            'required' => true,
        ]);
    }
}
