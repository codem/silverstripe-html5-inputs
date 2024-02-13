<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\ColorField;
use Codem\Utilities\HTML5\ColourField;
use SilverStripe\Dev\SapphireTest;

/**
 * ColourField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class ColourInputTest extends AbstractFieldTest
{

    public function testDataList()
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

    public function testInputType()
    {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = ColourField::create($name, $title, $value);
        $this->assertEquals('color', $field->getAttribute('type'));
    }

    public function testColourInput()
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
        foreach($colours as $colour => $expected) {
            // check field with value creation
            $name = $title = "field1{$i}";
            $field1 = ColourField::create($name, $title, $colour);
            $out = $field1->dataValue();
            $this->assertEquals($expected, $out, "The output {$out} does not match expected");

            // check set/get value
            $name = $title = "field2{$i}";
            $field2 = ColourField::create($name, $title, $out);
            $field2->setValue($colour);
            $out = $field2->Value();
            $this->assertEquals($expected, $out, "The output {$out} does not match expected (set/get value)");

            $i++;

        }

    }

    public function testDefaultValueNoDefaultProvided() {
        $name = "TestDefaultValue";
        $title = "Test default value";
        $value = null;
        $field = ColourField::create($name, $title, $value);
        $this->assertEquals(ColourField::WHITE, $field->getDefaultValue());
        $this->assertEquals(ColourField::WHITE, $field->Value());
    }

    public function testDefaultValueDefaultProvided() {
        $name = "TestDefaultValue";
        $title = "Test default value";
        $value = null;
        $defaultValue = "#0099ab";
        $field = ColourField::create($name, $title, $value, $defaultValue);
        $this->assertEquals($defaultValue, $field->getDefaultValue());
        $this->assertEquals($defaultValue, $field->Value());
    }

    public function testDefaultValueDefaultProvidedValueProvided() {
        $name = "TestDefaultValue";
        $title = "Test default value";
        $value = "#cc889a";
        $defaultValue = "#0099ab";
        $field = ColourField::create($name, $title, $value, $defaultValue);
        $this->assertEquals($defaultValue, $field->getDefaultValue());
        $this->assertEquals($value, $field->Value());
    }
}
