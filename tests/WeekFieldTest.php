<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\WeekField;

/**
 * WeekField input test
 */

require_once(__DIR__ . '/Base.php');

class WeekFieldTest extends Base
{
    public function testDataList(): void
    {
        $options = [
            '2019-W26' => 'Week 26, 2019'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = WeekField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = WeekField::create($name, $title, $value);
        $this->assertEquals('week', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = WeekField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '2020-W52';
        $field = WeekField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '2020-W54';
        $field = WeekField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
