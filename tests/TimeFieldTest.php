<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\TimeField;

/**
 * TimeField input test
 */

require_once(__DIR__ . '/Base.php');

class TimeFieldTest extends Base
{
    public function testDataList(): void
    {
        $options = [
            '13:00' => 'Lunch',
            '11:00' => 'Elevenses',
            '10:00' => '2nd breakfast',
            '8:00' => 'Breakfast',
            '16:00' => 'Afternoon Tea',
            '18:00' => 'Supper',
            '20:00' => 'Dinner'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = TimeField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = TimeField::create($name, $title, $value);
        $this->assertEquals('time', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = TimeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '01:30';
        $field = TimeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-value';
        $field = TimeField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
