<?php

namespace App\DataFixtures;

use App\Entity\ESR;
use App\Entity\ESRResult;
use App\Entity\ESRPartUsed;
use App\Entity\ESRPart;
use App\Entity\ESRLabor;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        /**
         * SELECT esr.serial_no, esrresult.passed, esrpart.description, esrpart_used.quantity, employee.first_name || ' ' || employee.last_name, esrlabor.labor_hours, esr.signed_by
         * FROM esr
         * FULL OUTER JOIN esrresult ON esr.esr_result_id=esrresult.id
         * FULL OUTER JOIN esrpart_used ON esr.id=esrpart_used.esr_id
         * FULL OUTER JOIN esrpart ON esrpart_used.esr_part_id=esrpart.id
         * FULL OUTER JOIN esrlabor ON esr.id=esrlabor.esr_id
         * FULL OUTER JOIN employee on esrlabor.employee_id=employee.id
         * FULL OUTER JOIN employee on esr.signed_by=employee.id;
         */

        // Results don't need to be instantiated before the ESR since the
        // value can be null. It's done here to keep code organized.
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


        $esr_1 = (new ESR())
        ->setSerialNo('12-12345-123')
        ->setModel('M8')
        ->setDescription('A sample ESR entry')
        ->setEsrResult($esr_result_1)
        ->setProblems('I have to insert entries to test')
        ->setActionTaken('I wrote a fixture to automate this.')
        ->setSignedBy($employee_1);
        $manager->persist($esr_1);


        $esr_part_1 = (new ESRPart())
        ->setPartNo('11-222-33-4')
        ->setDescription('Thingamabob')
        ->setPrice(50);
        $manager->persist($esr_part_1);

        $esr_part_2 = (new ESRPart())
        ->setPartNo('11-222-33-4')
        ->setDescription('Doodad')
        ->setPrice(1500);
        $manager->persist($esr_part_2);


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
