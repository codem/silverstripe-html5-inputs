<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\RangeField;
use SilverStripe\Dev\SapphireTest;

/**
 * RangeField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class RangeFieldTest extends AbstractFieldTest
{

    public function testDataList()
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
        $field = RangeField::create($name, $title, $value);
        $field->setMin(1);
        $field->setMax(13);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = RangeField::create($name, $title, $value);
        $this->assertEquals('range', $field->getAttribute('type'));
    }
}
