<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\NumberField;

/**
 * NumberField input test
 */

require_once(dirname(__FILE__) . '/Base.php');

class NumberFieldTest extends Base
{
    public function testDataList()
    {
        $options = [
            1 => 1,
            2 => 2,
            3 => 3,
            5 => 5,
            8 => 8
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = NumberField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = NumberField::create($name, $title, $value);
        $this->assertEquals('number', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation()
    {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = NumberField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation()
    {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 3;
        $field = NumberField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid());
    }


    public function testInvalidNonEmptyFieldButRequiredValidation()
    {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'abcd';
        $field = NumberField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
