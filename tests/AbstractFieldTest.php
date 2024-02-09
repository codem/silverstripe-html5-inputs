<?php

namespace Codem\Utilities\HTML5\Tests;

use SilverStripe\Dev\SapphireTest;

/**
 * Abstract class for field tests
 */

abstract class AbstractFieldTest extends SapphireTest
{

    protected $usesDatabase = false;

    protected function performDataListTest($field, $options)
    {

        $field->setDatalist($options);
        $template = $field->FieldHolder();

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($template);
        libxml_clear_errors();
        $datalist = $doc->getElementsByTagName('datalist')[0];
        $this->assertTrue($datalist->hasAttribute('id'), "<datalist> has id attribute");

        $option = $datalist->getElementsByTagName('option');
        $this->assertEquals(count($options), $option->length);

    }

}
