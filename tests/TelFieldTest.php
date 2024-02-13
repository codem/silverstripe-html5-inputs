<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\TelField;

/**
 * TelField input test
 */

require_once(dirname(__FILE__) . '/Base.php');

class TelFieldTest extends Base
{

    public function testDataList()
    {
        $options = [
            '1800 Testing' => 'phone 1',
            '1801 Testing' => 'phone 2',
            '1802 Testing' => 'phone 3',
            '1803 Testing' => 'phone 4',
            '1804 Testing' => 'phone 5'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = TelField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = TelField::create($name, $title, $value);
        $this->assertEquals('tel', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = TelField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'some value';
        $field = TelField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }
}
