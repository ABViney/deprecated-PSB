<?php

namespace App\Controller\Admin;

use Adeliom\EasyFieldsBundle\Admin\Field\FormTypeField;
use App\Entity\Employee;
use App\Entity\ESR;
use App\Form\ESRLaborType;
use App\Form\ESRPartUsedType;
use App\Form\ESRResultType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ESRCrudController extends AbstractCrudController
{

    public function __construct(

    )
    {}

    public static function getEntityFqcn(): string
    {
        return ESR::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Equipment Service Report')
            ->setEntityLabelInPlural('Equipment Service Reports')
            ->setDateTimeFormat(DateTimeField::FORMAT_SHORT, DateTimeField::FORMAT_MEDIUM)
            ->setFormOptions(['required' => false])
        /**
         * REVISE Put a listener on the login form, add an option in the user profile, or provide an admin/owner interface to set the timezone.
         * To implement a login listener, add a hidden field onto /templates/security/login.html.twig that's populated by a JS script.
         * Use Intl.DateTimeFormat().resolvedOptions().timeZone or { momentjs }
         */
            ->setTimezone('America/Chicago')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {   
        /**
         * TODO: Persist/update should render the final form. This form should then be saved
         * to the disk, and presented via the "detail" page. There should be a download and print button available.
         * Check KNPSnappy for the pdf gen.
         * 
         * Shortcut to compare multiple actions to the current page
         * 
         * @return bool if action matches current page
         * @return null if undefined action
         */
        $_isPage = 
        function (array|string $action) use ($pageName): ?bool
        {
            if ( 'string' === gettype($action) ) {
                // Supports single argument string
                $action = [$action];
            }
            switch ($pageName) {
                case Crud::PAGE_INDEX: 
                    if (in_array('index', $action)) return true;
                    break;

                case Crud::PAGE_NEW:
                    if (in_array('new', $action)) return true;
                    break;

                case Crud::PAGE_EDIT:
                    if (in_array('edit', $action)) return true;
                    break;

                case Crud::PAGE_DETAIL:
                    if (in_array('detail', $action)) return true;
                    break;
                default:
            }
            return null;
        };
        
        /**
         * Fields are defined close to where they are yielded.
         * Some fields are provided upon a condition, such as the
         * page name or current user.
         * Some fields may only yield inside conditional blocks
         * if there isn't a suitable widget for all views. 
         */

        //////
        // ID
        //////
        // $id = IdField::new('id')
        //     ->hideOnForm()
        // ;
        // yield $id;

        ////////////
        // Metadata
        ////////////
        yield $created_at = DateTimeField::new('created_at')
            ->hideOnForm()
            // ->formatValue($format_func)
        ;
        yield $last_modified = DateTimeField::new('last_modified')
            ->hideOnForm()
            // ->formatValue($format_func)
        ;

        /////////////
        // Serial No
        /////////////
        $serial_no = TextField::new('serial_no')
            ->hideOnIndex()
            ->setFormTypeOption('empty_data', '')
        ;
        yield $serial_no;

        /////////
        // Model
        /////////
        $model = TextField::new('model')
            ->hideOnIndex()
            ->setFormTypeOption('empty_data', '')
        ;
        yield $model;

        ///////////////
        // Description
        ///////////////
        $description = TextareaField::new('description')
            ->setFormTypeOption('empty_data', '')
        ;
        yield $description;

        ////////
        // Date
        ////////
        $date = DateField::new('date')
            ->setFormTypeOption('data', new \DateTimeImmutable())
        ;
        yield $date;

        //////////////
        // ESR Result
        // //////////////
        if ( $_isPage('index') ) {
            // Summarized as "Pass, Fail, or Not Assigned"
            yield $esr_result = ChoiceField::new('esr_result.passed', 'Inspection grade')
                ->formatValue( static function(/* string */ $value) {
                    return $value !== null ? ($value ? 'Pass' : 'Fail') : 'N/A';
                })
            ;
        }
        elseif ( $_isPage(['new', 'edit']) ) {
            // Uses a formtype to map the entity to the crud. Enforces one-to-one relationship for esr
            yield $esr_result = FormTypeField::new('esr_result', 'Service Summary', ESRResultType::class)
            ;
        }
        else {
            $esr_result_properties = [
                'estimate_required',
                'equipment_repair',
                'pm_pi_ovp_esi',
                'operation_calibration',
                'electrical_safety_test',
                'visual_inspection'
            ];
            foreach ($esr_result_properties as $property) {
                // Explode entity properties to page
                yield BooleanField::new('esr_result.'.$property)
                ;
            }
            yield BooleanField::new('esr_result.passed');
            yield TextField::new('esr_result.test_equipment_serial_no');
        }

        ////////////
        // Problems
        ////////////
        $problems = TextareaField::new('problems')
            ->hideOnIndex()
            ->setFormTypeOption('empty_data', '')
        ;
        yield $problems;

        ////////////////
        // Action Taken
        ////////////////
        $action_taken = TextareaField::new('action_taken')
            ->hideOnIndex()
            ->setFormTypeOption('empty_data', '')
        ;
        yield $action_taken;

        //////////////////
        // ESR Parts Used
        //////////////////
        $esr_parts_used = CollectionField::new('esr_parts_used', 'Parts used')
            ->setEntryType(ESRPartUsedType::class)
            ->renderExpanded()
            ->setFormTypeOption('delete_empty', true)
        ;
        if ( $_isPage('index') ) {
            // Summarized as sum of costs
            $esr_parts_used
                ->formatValue( function(string $value, ESR $esr) {
                    $esr_parts = $esr->getEsrPartsUsed();
                    $pennies = 0;
                    foreach ($esr_parts as $part) {
                        $pennies += $part->getEsrPart()->getPrice();
                    }
                    $dollars = number_format($pennies/100, 2, '.', ',');
                    return '$'.$dollars;
                })
            ;
        }
        yield $esr_parts_used;

        /**
         * On index only show names.
         * 
         * Otherwise provide all fields.
         */
        //////////////
        // ESR Labors
        //////////////
        if ( $_isPage('detail') ) {
            // yield = CollectionField::new('esr_labors', 'Total hours')
            //     ->formatValue(Collection $esr_labors)
            // ;
        }
        else {
            $esr_labors = CollectionField::new('esr_labors', 'Laborers')
                ->setEntryType(ESRLaborType::class)
                ->renderExpanded()
                ->setEntryIsComplex()
                ->setRequired(true)
            ;
            if ($_isPage('index')) {
                /**
                 * Summarize as comma delimitted list of employee names
                 */
                $esr_labors
                    ->formatValue( function(string $str, ESR $esr) {
                        $esr_labors = $esr->getEsrLabors();
                        $laborers = [];
                        /** @var ESRLabor */
                        foreach($esr_labors as $esr_labor) {
                            /** @var Employee */
                            $employee = $esr_labor->getEmployee();
                            $laborers[] = $employee->getFullName();
                        }
                        return implode(',', $laborers);
                    })
                ;
            }

            yield $esr_labors;
        }
        
        /**
         * On the index and detail page, show the name of the signer
         * 
         * New and edit pages do not avail the field. 
         * The signed_by field is applied pre-validation
         * and filled with the value of the authenticated
         * account's assigned employee.
         */
        /////////////
        // Signed by
        /////////////
        if ($_isPage(['index', 'detail'])) {
            yield $signed_by = AssociationField::new('signed_by', 'Signed by');;
        }
    }
   
}
