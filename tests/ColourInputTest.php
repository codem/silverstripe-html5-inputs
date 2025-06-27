<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\ColorField;
use Codem\Utilities\HTML5\ColourField;

/**
 * ColourField input test
 */

require_once(__DIR__ . '/Base.php');

class ColourInputTest extends Base
{
    public function testDataList(): void
    {
        $options = [
            '#ff0000' => 'Red',
            '#00ff00' => 'Green',
            '#0000ff' => 'Blue',
            '#000000' => "Black",
            '#ffffff' => "White"
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = ColourField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = ColourField::create($name, $title, $value);
        $this->assertEquals('color', $field->getAttribute('type'));
    }

    public function testColourInput(): void
    {
        $colours = [
            // in => expected
            '' => '#ffffff',//empty values default to white
            '#000000' => '#000000',// OK
            '#000' => '#ffffff',// not valid, use default
            'ayz' => '#ffffff',// not a valid colour
            '#32ac983' => '#ffffff',// invalid length
            '#32ac98' => '#32ac98',// OK
            '#32az98' => '#ffffff',// not hex
        ];

        $i = 1;
        foreach ($colours as $colour => $expected) {
            // check field with value creation
            $name = "field1{$i}";
            $title = "field1{$i}";
            $field1 = ColourField::create($name, $title, $colour);
            $out = $field1->getValue();
            $this->assertEquals($expected, $out, "The output {$out} does not match expected");
            // check set/get value
            $name = "field2{$i}";
            $title = "field2{$i}";
            $field2 = ColourField::create($name, $title, $out);
            $field2->setValue($colour);
            $out = $field2->getValue();
            $this->assertEquals($expected, $out, "The output {$out} does not match expected (set/get value)");

            $i++;

        }

    }

    public function testDefaultValueNoDefaultProvided(): void
    {
        $name = "TestDefaultValue";
        $title = "Test default value";
        $value = null;
        $field = ColourField::create($name, $title, $value);
        $this->assertEquals(ColourField::WHITE, $field->getDefaultValue());
        $this->assertEquals(ColourField::WHITE, $field->getValue());
    }

    public function testDefaultValueDefaultProvided(): void
    {
        $name = "TestDefaultValue";
        $title = "Test default value";
        $value = null;
        $defaultValue = "#0099ab";
        $field = ColourField::create($name, $title, $value, $defaultValue);
        $this->assertEquals($defaultValue, $field->getDefaultValue());
        $this->assertEquals($defaultValue, $field->getValue());
    }

    public function testDefaultValueDefaultProvidedValueProvided(): void
    {
        $name = "TestDefaultValue";
        $title = "Test default value";
        $value = "#cc889a";
        $defaultValue = "#0099ab";
        $field = ColourField::create($name, $title, $value, $defaultValue);
        $this->assertEquals($defaultValue, $field->getDefaultValue());
        $this->assertEquals($value, $field->getValue());
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = ColourField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        // empty values are converted to the field default
        $this->assertTrue($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = '#cc33ff';
        $field = ColourField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid());
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'abcd';
        $field = ColourField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        // invalid values are converted to the field default
        $this->assertTrue($result->isValid());
    }
}
