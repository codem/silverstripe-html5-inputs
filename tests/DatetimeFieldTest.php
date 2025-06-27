<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\DatetimeField;

/**
 * DatetimeField input test
 */

require_once(dirname(__FILE__) . '/Base.php');

class DatetimeFieldTest extends Base
{
    public function testDataList()
    {
        $options = [
            '2018-01-01 12:30' => 'Option 1',
            '2027-03-02 13:30' => 'Option 2',
            '1900-12-31 14:40' => 'Option 3'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = DatetimeField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = DatetimeField::create($name, $title, $value);
        $this->assertEquals('datetime-local', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation()
    {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = DatetimeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation()
    {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '2020-01-01T01:30';
        $field = DatetimeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }


    public function testInvalidNonEmptyFieldButRequiredValidation()
    {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-value';
        $field = DatetimeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
