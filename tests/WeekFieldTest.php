<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\WeekField;
use SilverStripe\Dev\SapphireTest;

/**
 * WeekField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class WeekFieldTest extends AbstractFieldTest
{

    public function testDataList()
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

    public function testInputType()
    {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = WeekField::create($name, $title, $value);
        $this->assertEquals('week', $field->getAttribute('type'));
    }
}
