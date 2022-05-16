<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\UrlField;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\RequiredFields;

/**
 * URLField input test
 */

require_once(dirname(__FILE__) . '/AbstractFieldTest.php');

class URLFieldTest extends AbstractFieldTest
{

    public function testDataList() {
        $options = [
            'https://example.com' => 'Example.com',
            'https://example.org' => 'Example.org',
            'exampl.net' => 'Example.net'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = UrlField::create($name, $title, $value);
        $this->performDataListTest( $field, $options);
    }

    public function testInputType() {
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = UrlField::create($name, $title, $value);
        $this->assertEquals('url', $field->getAttribute('type'));
    }

    public function testHttpScheme() {
        $url = 'ftp://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->restrictToHttp();
        $schemes = $field->getSchemes();
        $this->assertContains('http', $schemes);
        $this->assertContains('https', $schemes);

        $pattern = $field->getPattern();
        $phpPattern = $field->getPHPPattern();

        $expectedPattern = "^(https|http)://.*";
        $expectedPhpPattern = "/^(https|http):\/\/.*/";
        $this->assertEquals($expectedPattern, $pattern);
        $this->assertEquals($expectedPhpPattern, $expectedPhpPattern);

        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate");

    }

    public function testHttpsScheme() {
        $url = 'http://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->restrictToHttps();
        $schemes = $field->getSchemes();
        $this->assertNotContains('http', $schemes);
        $this->assertContains('https', $schemes);

        $pattern = $field->getPattern();
        $phpPattern = $field->getPHPPattern();

        $expectedPattern = "^(https)://.*";
        $expectedPhpPattern = "/^(https):\/\/.*/";
        $this->assertEquals($expectedPattern, $pattern);
        $this->assertEquals($expectedPhpPattern, $expectedPhpPattern);

        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate");
    }

    public function testRequiredParts() {
        $url = 'https://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->setRequiredParts(['scheme','query']);
        $result = $field->parseURL($url);

        $this->assertTrue($result, 'parseURL failed to pick up scheme and query in valid URL');
    }

    public function testRequiredPartsMissing() {
        $url = 'https://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->setRequiredParts(['scheme','query', 'fragment']);
        $result = $field->parseURL($url);

        $this->assertFalse($result, 'parseURL failed when finding fragment in URL with no fragment');
    }

    public function testNonStandardSchemes() {
        $url = 'https://www.example.com/path?foo=bar';
        $schemes = ['blob','chrome','dict'];
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->restrictToSchemes($schemes);
        $resultSchemes = $field->getSchemes();
        $this->assertEquals($schemes, $resultSchemes);

        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate");

    }

    public function testWithPattern() {
        $url = 'ftp://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $pattern = "^ftp://.+\.com";
        $phpPattern = "|^ftp://.+\.com|";
        $field->setPattern($pattern, $phpPattern);
        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertTrue($result, "Field should validate for url {$url}");
    }

    public function testWithPatternToFail() {
        $url = 'ftp://www.example.org/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $pattern = "^ftp://.+\.example\.com";
        $phpPattern = "|^ftp://.+\.example\.com|";
        $field->setPattern($pattern, $phpPattern);
        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate for url {$url}");
    }

}
