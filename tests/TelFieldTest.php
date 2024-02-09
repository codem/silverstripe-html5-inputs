<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\TelField;
use SilverStripe\Dev\SapphireTest;

/**
 * TelField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class TelFieldTest extends AbstractFieldTest
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
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = TelField::create($name, $title, $value);
        $this->assertEquals('tel', $field->getAttribute('type'));
    }
}
