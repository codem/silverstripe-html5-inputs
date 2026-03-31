<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\NumberField;

/**
 * NumberField input test
 */

require_once(__DIR__ . '/Base.php');

class NumberFieldTest extends Base
{
    public function testDataList(): void
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

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = NumberField::create($name, $title, $value);
        $this->assertEquals('number', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = NumberField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '3';// string values are submitted
        $field = NumberField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid());
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'abcd';
        $field = NumberField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
