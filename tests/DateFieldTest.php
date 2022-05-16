<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\DateField;
use SilverStripe\Dev\SapphireTest;

/**
 * DateField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class DateFieldTest extends AbstractFieldTest
{

    public function testDataList() {
        $options = [
            '2018-01-01' => 'Option 1',
            '2027-03-02' => 'Option 2',
            '1900-12-31' => 'Option 3'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = DateField::create($name, $title, $value);
        $this->performDataListTest( $field, $options);
    }

    public function testInputType() {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = DateField::create($name, $title, $value);
        $this->assertEquals('date', $field->getAttribute('type'));
    }
}
