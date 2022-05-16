<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\SearchField;
use SilverStripe\Dev\SapphireTest;

/**
 * SearchField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class SearchFieldTest extends AbstractFieldTest
{

    public function testDataList() {
        $options = [
            'horse',
            'cow',
            'dog',
            'cat'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = SearchField::create($name, $title, $value);
        $this->performDataListTest( $field, $options);
    }

    public function testInputType() {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = SearchField::create($name, $title, $value);
        $this->assertEquals('search', $field->getAttribute('type'));
    }
}
