<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\TimeField;
use SilverStripe\Dev\SapphireTest;

/**
 * TimeField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class TimeFieldTest extends AbstractFieldTest
{

    public function testDataList() {
        $options = [
            '13:00' => 'Lunch',
            '11:00' => 'Elevenses',
            '10:00' => '2nd breakfast',
            '8:00' => 'Breakfast',
            '16:00' => 'Afternoon Tea',
            '18:00' => 'Supper',
            '20:00' => 'Dinner'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = TimeField::create($name, $title, $value);
        $this->performDataListTest( $field, $options);
    }

    public function testInputType() {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = TimeField::create($name, $title, $value);
        $this->assertEquals('time', $field->getAttribute('type'));
    }
}
