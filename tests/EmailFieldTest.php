<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\EmailField;

/**
 * EmailField input test
 */

require_once(__DIR__ . '/Base.php');

class EmailFieldTest extends Base
{
    public function testDataList(): void
    {
        $options = [
            'barry@example.com' => 'Barry',
            'steve@example.org' => 'Steve',
            'jane@example.net' => 'Jane'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = EmailField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = EmailField::create($name, $title, $value);
        $this->assertEquals('email', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = EmailField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'someone@example.com';
        $field = EmailField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid());
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-email-value';
        $field = EmailField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }
}
