<?php

namespace App\Form;

use App\Entity\ESRResult;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ESRResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estimate_required', CheckboxType::class, [
                'label' => 'Estimate Required',
                'required' => false,
            ])
            ->add('equipment_repair', CheckboxType::class, [
                'label' => 'Equipment Repair',
                'required' => false,
            ])
            ->add('pm_pi_ovp_esi', CheckboxType::class, [
                'label' => 'PM/PI/OVP/ESI',
                'help' => 'PM - Preventative Maintenance/PI - Preventative Inspection/OVP - Operational Verifcation Performance/ESI - Electrical Safety Inspection',
                'required' => false,
            ])
            ->add('operation_calibration', CheckboxType::class, [
                'label' => 'Operation/Calibration per Mfg. Spec.',
                'required' => false,
            ])
            ->add('electrical_safety_test', CheckboxType::class, [
                'label' => 'Electrical Safety Test',
                'required' => false,
            ])
            ->add('visual_inspection', CheckboxType::class, [
                'label' => 'Visual Inspection',
                'required' => false,
            ])
            ->add('passed', ChoiceType::class, [
                'choices' => [
                    'Pass' => true,
                    'Fail' => false,
                ],
                'placeholder' => 'N/A',
                'expanded' => true,
                'required' => false,
            ])
            ->add('test_equipment_serial_no', TextType::class, [
                'attr' => ['placeholder' => 'N/A'],
                'empty_data' => 'N/A',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ESRResult::class,
        ]);
    }
}
