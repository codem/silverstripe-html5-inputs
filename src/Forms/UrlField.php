<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\TextField;
use SilverStripe\ORM\ValidationResult;

/**
 * Provides a URL input field
 */
class UrlField extends TextField {

    use Core;
    use Datalist;
    use Pattern;

    /**
     * @var string
     */
    protected $template = "Codem/Utilities/HTML5/UrlField";

    /**
     * @var string
     */
    protected $inputType = 'url';

    /**
     * An array of schemes that must be matched
     * @var array
     */
    protected $schemes = [];

    /**
     * Parts of the URL that must be present
     * One or more of the potential keys within the return array of parse_url()
     * By default the field requires a scheme and host to be present
     * @var array
     */
    protected $requiredParts = ['scheme','host'];

    /**
     * TODO: use domain validation to validate the URL
     *
     * @param Validator $validator
     *
     * @return boolean
     */
    public function validate($validator)
    {
        $value = $this->dataValue();
        if(empty($value)) {
            // Use RequiredFields to validate empty submissions
            return true;
        }

        $check = $this->validateValueAgainstPattern();
        if($check != 1) {
            // validation failed
            $validator->validationError(
                $this->getName(),
                _t(
                    'Codem\\Utilities\\HTML5\\UrlField.FAILED_PATTERN_VALIDATION',
                    'The URL provided does not match the format requested'
                ),
                ValidationResult::TYPE_ERROR
            );
            // Pattern validation failed
            return false;
        }

        // Check for valid URL format
        if(!$this->parseURL($this->dataValue())) {
            $validator->validationError(
                $this->getName(),
                _t(
                    'Codem\\Utilities\\HTML5\\UrlField.FAILED_URL_PARSE',
                    'The value provided does not appear to be a well-formed URL'
                ),
                ValidationResult::TYPE_ERROR
            );
            return false;
        }

        return true;
    }

    public function setRequiredParts(array $requiredParts) {
        $this->requiredParts = $requiredParts;
        return $this;
    }

    /**
     * Parse a possible URL string
     * If the second parameter is provided, the URL must have those parts
     */
    public function parseURL(string $url) : bool {
        if($url == '') {
            // an empty URL is a valid URL
            return true;
        }
        // Check for valid URL format
        $parts = parse_url($url);
        if(empty($this->requiredParts)) {
            return !empty($parts);
        }  else {
            // ensure all of the required parts are present in all of the keys
            $result = array_intersect($this->requiredParts, array_keys($parts));
            sort($result);
            sort($this->requiredParts);
            return $result == $this->requiredParts;
        }
    }

    /**
     * Schemes are set by calling restrictToSchemes
     */
    protected function setSchemes(array $schemes) {
        $this->schemes = $schemes;
        return $this;
    }

    public function getSchemes() {
        return $this->schemes;
    }

    /**
     * Restrict to http (and https) protocols
     */
    public function restrictToHttp() {
        $this->restrictToSchemes(["https","http"]);
        $this->setAttribute(
            'placeholder',
            _t(
                'Codem\\Utilities\\HTML5\\UrlField.PLACEHOLDER_SCHEME_HTTP',
                'Provide a URL starting with http:// or https://'
            )
        );
        return $this;
    }

    /**
     * Restrict to URLs beginning with https://
     */
    public function restrictToHttps() {
        return $this->restrictToSchemes(["https"]);
    }

    /**
     * Restrict to URLs beginning with the provided scheme
     */
    public function restrictToSchemes(array $schemes) {
        $this->setSchemes($schemes);
        $schemesString = implode("://, ", $schemes)  . "://";
        $this->setAttribute(
            'placeholder',
            _t(
                'Codem\\Utilities\\HTML5\\UrlField.PLACEHOLDER_SCHEME',
                'Please provide a URL starting with {schemes}',
                [
                    'schemes' => $schemesString
                ]
            )
        );
        // JS pattern
        $pattern = "^(" . implode("|", $schemes) . ")://.*";
        // PHP
        $phpPattern = "/^(" . implode("|", $schemes) . "):\/\/.*/";
        return $this->setPattern($pattern, $phpPattern);
    }
}
