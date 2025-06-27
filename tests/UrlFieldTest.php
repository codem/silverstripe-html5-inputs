<?php

namespace Codem\Utilities\HTML5\Tests;

use Codem\Utilities\HTML5\UrlField;
use SilverStripe\Forms\RequiredFields;

/**
 * URLField input test
 */

require_once(__DIR__ . '/Base.php');

class UrlFieldTest extends Base
{
    public function testDataList(): void
    {
        $options = [
            'https://example.com' => 'Example.com',
            'https://example.org' => 'Example.org',
            'exampl.net' => 'Example.net'
        ];
        $name = "TestDatalist";
        $title = "Test datalist";
        $value = null;
        $field = UrlField::create($name, $title, $value);
        $this->performDataListTest($field, $options);
    }

    public function testInputType(): void
    {
        $name = "TestInputType";
        $title = "Test input type";
        $value = null;
        $field = UrlField::create($name, $title, $value);
        $this->assertEquals('url', $field->getAttribute('type'));
    }

    public function testHttpScheme(): void
    {
        $url = 'ftp://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->restrictToHttp();

        $schemes = $field->getSchemes();
        $this->assertContains('http', $schemes);
        $this->assertContains('https', $schemes);

        $pattern = $field->getPattern();

        $expectedPattern = "^(https|http)://.*";
        $expectedPhpPattern = "/^(https|http):\/\/.*/";
        $this->assertEquals($expectedPattern, $pattern);
        $this->assertEquals($expectedPhpPattern, $expectedPhpPattern);

        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate");

    }

    public function testHttpsScheme(): void
    {
        $url = 'http://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->restrictToHttps();

        $schemes = $field->getSchemes();
        $this->assertNotContains('http', $schemes);
        $this->assertContains('https', $schemes);

        $pattern = $field->getPattern();

        $expectedPattern = "^(https)://.*";
        $expectedPhpPattern = "/^(https):\/\/.*/";
        $this->assertEquals($expectedPattern, $pattern);
        $this->assertEquals($expectedPhpPattern, $expectedPhpPattern);

        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate");
    }

    public function testRequiredParts(): void
    {
        $url = 'https://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->setRequiredParts(['scheme','query']);

        $result = $field->parseURL($url);

        $this->assertTrue($result, 'parseURL failed to pick up scheme and query in valid URL');
    }

    public function testRequiredPartsMissing(): void
    {
        $url = 'https://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $field->setRequiredParts(['scheme','query', 'fragment']);

        $result = $field->parseURL($url);

        $this->assertFalse($result, 'parseURL failed when finding fragment in URL with no fragment');
    }

    public function testNonStandardSchemes(): void
    {
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

    public function testWithPattern(): void
    {
        $url = 'ftp://www.example.com/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $pattern = "^ftp://.+\.com";
        $phpPattern = "|^ftp://.+\.com|";
        $field->setPattern($pattern, $phpPattern);
        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertTrue($result, "Field should validate for url {$url}");
    }

    public function testWithPatternToFail(): void
    {
        $url = 'ftp://www.example.org/path?foo=bar';
        $field = UrlField::create('TestURL', 'Test URL', $url);
        $pattern = "^ftp://.+\.example\.com";
        $phpPattern = "|^ftp://.+\.example\.com|";
        $field->setPattern($pattern, $phpPattern);
        $validator = new RequiredFields();
        $result = $field->validate($validator);
        $this->assertFalse($result, "Field should not validate for url {$url}");
    }

    public function testEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = null;
        $field = UrlField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

    public function testNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'https://example.com/something.txt';
        $field = UrlField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertTrue($result->isValid(), "Validation result is true");
    }


    public function testInvalidNonEmptyFieldButRequiredValidation(): void
    {
        $fieldName = "TestValidation";
        $fieldTitle = "Test validation";
        $fieldValue = 'invalid-value';
        $field = UrlField::create($fieldName, $fieldTitle, $fieldValue);
        $result = $this->getRequiredFieldValidationResult($field);
        $this->assertFalse($result->isValid());
    }

}
