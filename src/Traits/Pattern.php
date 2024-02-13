<?php

namespace Codem\Utilities\HTML5;

/**
 * pattern handling for supporting inputs
 * @author James
 */
trait Pattern
{

    /**
     * @var string
     */
    protected $phpPattern = '';

    /**
     * Set a string pattern value for the pattern attribute
     * @param string $pattern
     * @param string $phpPattern optional regular expression for use in server side validation. If not provided, $pattern will be used. Helpful when the JS RegExp won't compile.
     * @return FormField
     */
    public function setPattern(string $pattern, string $phpPattern = '') : self
    {
        $this->setAttribute('pattern', $pattern);
        $this->phpPattern = $phpPattern;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPattern()
    {
        return $this->getAttribute('pattern');
    }

    /**
     * @return string
     */
    public function getPHPPattern() : string
    {
        return $this->phpPattern;
    }

    /**
     * Validate the value against the provided php regex pattern
     * When providing a pattern, you must provide the corresponding php regular expression
     */
    public function validateValueAgainstPattern() : bool
    {
        $pattern = $this->phpPattern;
        if(!$pattern) {
            $pattern = $this->getPattern();
            if(!$pattern) {
                // no pattern
                return true;
            }
        }
        $value = $this->Value() ?? '';
        $check = preg_match($pattern, $value, $matches);
        return $check === 1;
    }

}
