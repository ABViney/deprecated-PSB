<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\ESRLabor;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ESRLaborType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('employee', EmployeeType::class)
            ->add('employee', EntityType::class, [
                'label' => 'Employee',
                'class' => Employee::class,
            ])
            // REVISE: A widget that can specify start/stop times
            // TODO: A transformer to render said widget to float
            ->add('labor_hours', NumberType::class, [
                'label' => 'Hours',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ESRLabor::class,
        ]);
    }
}
