<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\RangeField;

/**
 * RangeField input test
 */

require_once(dirname(__FILE__) . '/Base.php');

class RangeFieldTest extends Base
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
        $field = RangeField::create($name, $title, $value);
        $field->setMin(1);
        $field->setMax(13);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = RangeField::create($name, $title, $value);
        $this->assertEquals('range', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = RangeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 3;
        $field = RangeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }


    public function testInvalidNonEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-value';
        $field = RangeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
