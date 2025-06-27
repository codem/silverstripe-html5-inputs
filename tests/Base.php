<?php

namespace Codem\Utilities\HTML5\Tests;

use SilverStripe\Control\Controller;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\ValidationResult;

/**
 * Abstract class for field tests
 */

abstract class Base extends SapphireTest
{
    protected $usesDatabase = false;

    protected function performDataListTest($field, $options)
    {

        $field->setDatalist($options);
        $template = $field->FieldHolder();

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($template);
        libxml_clear_errors();
        $datalist = $doc->getElementsByTagName('datalist')[0];
        $this->assertTrue($datalist->hasAttribute('id'), "<datalist> has id attribute");

        $option = $datalist->getElementsByTagName('option');
        $this->assertEquals(count($options), $option->length);

    }

    public function getRequiredFieldValidationResult(FormField $field): ValidationResult
    {
        $controller = Controller::create();
        $validator = RequiredFields::create([$field->getName()]);
        $form = Form::create(
            $controller,
            'RequiredFieldTestForm',
            FieldList::create([ $field ]),
            FieldList::create(),
            $validator
        );
        return $form->validationResult();
    }

}
