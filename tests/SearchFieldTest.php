<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\SearchField;

/**
 * SearchField input test
 */

require_once(dirname(__FILE__) . '/Base.php');

class SearchFieldTest extends Base
{

    public function testDataList()
    {
        $options = [
            'horse',
            'cow',
            'dog',
            'cat'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = SearchField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = SearchField::create($name, $title, $value);
        $this->assertEquals('search', $field->getAttribute('type'));
    }

    public function testEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = SearchField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation() {
        $formName = "TestFormValidation";
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'keyword';
        $field = SearchField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }
}
