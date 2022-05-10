<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\NumberField;
use SilverStripe\Dev\SapphireTest;

/**
 * NumberField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class NumberFieldTest extends AbstractFieldTest
{

    public function testDataList() {
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
        $this->performDataListTest( $field, $options);
    }

    public function testInputType() {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = NumberField::create($name, $title, $value);
        $this->assertEquals('number', $field->getAttribute('type'));
    }
}
