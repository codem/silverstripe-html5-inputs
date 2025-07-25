<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\DateField;

/**
 * DateField input test
 */

require_once(__DIR__ . '/Base.php');

class DateFieldTest extends Base
{
    public function testDataList(): void
    {
        $options = [
            '2018-01-01' => 'Option 1',
            '2027-03-02' => 'Option 2',
            '1900-12-31' => 'Option 3'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = DateField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = DateField::create($name, $title, $value);
        $this->assertEquals('date', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = DateField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '2020-01-01';
        $field = DateField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid());
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-value';
        $field = DateField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
