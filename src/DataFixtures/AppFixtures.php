<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\ESR;
use App\Entity\ESRResult;
use App\Entity\ESRPartUsed;
use App\Entity\ESRPart;
use App\Entity\ESRLabor;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    )
    {}

    public function load(ObjectManager $manager): void
    {   
        $esr_result_1 = (new ESRResult())
        ->setVisualInspection(true)
        ->setPassed(true);
        $manager->persist($esr_result_1);


        $employee_1 = (new Employee())
        ->setFirstName('Owner')
        ->setLastName('Man');
        $manager->persist($employee_1);

        $employee_2 = (new Employee())
        ->setFirstName('John')
        ->setLastName('Madden');
        $manager->persist($employee_2);

        $employee_3 = (new Employee())
        ->setFirstName('Steve')
        ->setLastName('Jerbs');
        $manager->persist($employee_3);


        $hasher = $this->passwordHasherFactory->getPasswordHasher(Account::class);

        $account_1 = (new Account())
        ->setUsername('owner')
        ->setEmail('owner@psb.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($hasher->hash('man'))
        ->setAssignedTo($employee_1);
        $manager->persist($account_1);

        $account_2 = (new Account())
        ->setUsername('john')
        ->setEmail('johnmadden@psb.com')
        ->setRoles(['ROLE_EMPLOYEE'])
        ->setPassword($hasher->hash('madden'))
        ->setAssignedTo($employee_2);
        $manager->persist($account_2);

        $account_3 = (new Account())
        ->setUsername('steve')
        ->setEmail('stevejerbs@psb.com')
        ->setRoles(['ROLE_EMPLOYEE'])
        ->setPassword($hasher->hash('jerbs'))
        ->setAssignedTo($employee_3);
        $manager->persist($account_3);

        $account_4 = (new Account())
        ->setUsername('admin')
        ->setEmail('admin@psb.com')
        ->setRoles(['ROLE_SUPER_ADMIN'])
        ->setPassword($hasher->hash('admin'))
        ->setAssignedTo($employee_1);
        $manager->persist($account_4);

        $esr_1 = (new ESR())
        ->setSerialNo('12-12345-123')
        ->setModel('M8')
        ->setDescription('A sample ESR entry')
        ->setDate(\DateTimeImmutable::createFromFormat('m-d-Y H:i:s', '05-05-2005 11:00:00'))
        ->setEsrResult($esr_result_1)
        ->setProblems('I have to insert entries to test')
        ->setActionTaken('I wrote a fixture to automate this.')
        ->setSignedBy($employee_1);
        $manager->persist($esr_1);


        $esr_part_1 = (new ESRPart())
        ->setPartNo('11-222-EE-4')
        ->setDescription('Thingamabob')
        ->setPrice(50);
        $manager->persist($esr_part_1);

        $esr_part_2 = (new ESRPart())
        ->setPartNo('86-75-309')
        ->setDescription('Doodad')
        ->setPrice(1500);
        $manager->persist($esr_part_2);

        $esr_part_3 = (new ESRPart())
        ->setPartNo('51-50-P0P0')
        ->setDescription('Doohickey')
        ->setPrice(1499);
        $manager->persist($esr_part_3);


        $esr_part_used_1 = (new ESRPartUsed())
        ->setEsr($esr_1)
        ->setEsrPart($esr_part_1)
        ->setQuantity(2);
        $manager->persist($esr_part_used_1);

        $esr_part_used_2 = (new ESRPartUsed())
        ->setEsr($esr_1)
        ->setEsrPart($esr_part_2)
        ->setQuantity(1);
        $manager->persist($esr_part_used_2);

        $esr_part_used_3 = (new ESRPartUsed())
        ->setEsr($esr_1)
        ->setEsrPart($esr_part_3)
        ->setQuantity(3);
        $manager->persist($esr_part_used_3);


        $esr_labor_1 = (new ESRLabor())
        ->setEsr($esr_1)
        ->setEmployee($employee_1)
        ->setLaborHours(3.50);
        $manager->persist($esr_labor_1);

        $esr_labor_2 = (new ESRLabor())
        ->setEsr($esr_1)
        ->setEmployee($employee_2)
        ->setLaborHours(11);
        $manager->persist($esr_labor_2);
        

        
        $manager->flush();
    }
}
