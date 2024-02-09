<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\MonthField;
use SilverStripe\Dev\SapphireTest;

/**
 * MonthField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class MonthFieldTest extends AbstractFieldTest
{

    public function testDataList()
    {
        $options = [
            '2019-07' => 'July 2019',
            '2030-12' => 'Dec 2030',
            '2400-01' => 'January 2400'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = MonthField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType()
    {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = MonthField::create($name, $title, $value);
        $this->assertEquals('month', $field->getAttribute('type'));
    }
}
