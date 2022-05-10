<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\EmailField;
use SilverStripe\Dev\SapphireTest;

/**
 * EmailField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class EmailFieldTest extends AbstractFieldTest
{

    public function testDataList() {
        $options = [
            'barry@example.com' => 'Barry',
            'steve@example.org' => 'Steve',
            'jane@example.net' => 'Jane'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = EmailField::create($name, $title, $value);
        $this->performDataListTest( $field, $options);
    }

    public function testInputType() {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = EmailField::create($name, $title, $value);
        $this->assertEquals('email', $field->getAttribute('type'));
    }
}
