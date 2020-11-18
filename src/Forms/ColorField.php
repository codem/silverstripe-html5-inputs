<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\TextField;
use SilverStripe\Forms\Validator;

/**
 * Provides a colour picker / field
 * @see https://www.w3.org/wiki/Html/Elements/input/color
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color#Value wrt value
 */
class ColorField extends TextField {

    use Core;
    use Datalist;

    protected $template = "Codem/Utilities/HTML5/ColorField";

    protected $inputType = 'color';

    protected $defaultValue = "#ffffff";

    /**
     * Returns the value saved as a 6 chr RGB colour with # prefixed
     * @return string
     */
    public function dataValue() {
        $value = $this->getValidRGB($this->value);
        return $value;
    }

    /**
     * @return string
     */
    public function Value()
    {
        return $this->dataValue();
    }

    /**
     * When the value is set, handle incorrect values
     * @param string $value an RGB colour value as a 'valid simple colour'
     * @return void
     */
    public function setValue($value, $data = null) {
        $this->value = $this->getValidRGB($value);
    }

    /**
     * Base on the value return either the defaultValue colour value or the value
     * @return string
     * @param string $value the value to check
     * @param Validator $validator optional, if set relevant errors will be added
     *
     * The only valid value here is defined by the "valid simple colour" definition at
     * https://html.spec.whatwg.org/multipage/common-microsyntaxes.html#valid-simple-colour
     *
     * <blockquote>A string is a valid simple color if it is exactly seven characters long,
     *    and the first character is a U+0023 NUMBER SIGN character (#), and the
     *    remaining six characters are all ASCII hex digits, with the first two digits
     *    representing the red component, the middle two digits representing the green component,
     *  and the last two digits representing the blue component, in hexadecimal.</blockquote>
     */
    public function getValidRGB($value, Validator $validator = null) {

        // empty values default to the empty value value
        if(!$value) {
            return $this->defaultValue;
        }

        $value = strtolower($value);

        // If input is not exactly seven characters long, then return an error.
        if(mb_strlen( $value ) != 7) {
            if($validator) {
                $validator->validationError(
                    $this->name,
                    _t(
                        'Codem\\Utilities\\HTML5\\ColorField.VALIDATE_NOT_VALID_RGB',
                        'The colour value must be a 6 character RGB colour value in the range #000000 to #ffffff'
                    ),
                    "validation"
                );
            }
            return $this->defaultValue;
        }

        // If the first character in input is not a U+0023 NUMBER SIGN character (#), then return an error.
        if(strpos($value, "#") !== 0) {
            if($validator) {
                $validator->validationError(
                    $this->name,
                    _t(
                        'Codem\\Utilities\\HTML5\\ColorField.VALIDATE_MISSING_HASH',
                        'The colour value must start with a # character'
                    ),
                    "validation"
                );
            }
            return $this->defaultValue;
        }

        // If the last six characters of input are not all ASCII hex digits, then return an error.
        $hex = trim($value, "#");
        if(ctype_xdigit($hex) === false) {
            if($validator) {
                $validator->validationError(
                    $this->name,
                    _t(
                        'Codem\\Utilities\\HTML5\\ColorField.VALIDATE_NOT_VALID_RGB',
                        'The colour value must be a valid 6 character RGB colour value in the range #000000 to #ffffff'
                    ),
                    "validation"
                );
            }
            return $this->defaultValue;
        }

        // Let result be a simple color.
        return $value;
    }

    /**
     * Validate this field
     *
     * @param Validator $validator
     * @return bool
     */
    public function validate($validator)
    {
        if(!$this->getValidRGB($this->value, $validator)) {
            return false;
        }
        return true;
    }

}

/**
 * Provides a class for those of us not using en_US
 */
class ColourField extends ColorField {

    protected $template = "Codem/Utilities/HTML5/ColorField";

}
