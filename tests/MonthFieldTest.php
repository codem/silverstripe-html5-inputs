<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\MonthField;

/**
 * MonthField input test
 */

require_once(dirname(__FILE__) . '/Base.php');

class MonthFieldTest extends Base
{

    public function testDataList()
    {
        $options = [
            '2019-07' => 'July 2019',
            '2030-12' => 'Dec 2030',
            '2400-01' => 'January 2400'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = MonthField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = MonthField::create($name, $title, $value);
        $this->assertEquals('month', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = MonthField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '2020-01';
        $field = MonthField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }


    public function testInvalidNonEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-value';
        $field = MonthField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
