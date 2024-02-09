<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\DatetimeField;
use SilverStripe\Dev\SapphireTest;

/**
 * DatetimeField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class DatetimeFieldTest extends AbstractFieldTest
{

    public function testDataList()
    {
        $options = [
            '2018-01-01 12:30' => 'Option 1',
            '2027-03-02 13:30' => 'Option 2',
            '1900-12-31 14:40' => 'Option 3'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = DatetimeField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = DatetimeField::create($name, $title, $value);
        $this->assertEquals('datetime-local', $field->getAttribute('type'));
    }
}
