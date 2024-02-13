<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\FormField;
use SilverStripe\Forms\Validator;

/**
 * Provides a colour picker / field
 *
 * @see https://www.w3.org/wiki/Html/Elements/input/color
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color#Value wrt value
 * @see https://html.spec.whatwg.org/multipage/input.html#color-state-(type=color) (default colour)
 *
 * Default value
 * =============
 * The colour input is special in that it does not allow an empty value within the current spec.
 * The browser will always send through the default colour in the spec (#000000) if none is supplied
 *
 * In this implementation, the default field value set is static::WHITE
 */
class ColorField extends FormField
{

    use Core;
    use Datalist;

    /**
     * @var string
     */
    const WHITE = "#ffffff";

    /**
     * @var string
     */
    protected $inputType = 'color';

    /**
     * This is the default colour for the input,
     * if no value is set, or if the value provided is not a valid hex colour string
     * On field construction this will be set to white
     * @var string|null
     */
    protected $defaultValue = null;

    /**
     * Returns a colour input field
     *
     * @param string $name
     * @param null|string $title
     * @param string $value
     * @param string $defaultValue the default value to use for the input
     *
     */
    public function __construct($name, $title = null, $value = '', $defaultValue = '')
    {
        $this->setDefaultValue($defaultValue);
        parent::__construct($name, $title, $value);
    }

    /**
     * Returns the value saved as a 6 chr RGB colour with # prefixed
     * @return string
     */
    public function dataValue()
    {
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
     */
    public function setValue($value, $data = null)
    {
        $this->value = $this->getValidRGB($value);
        return $this;
    }


    /**
     * Set the default value to be used if an invalid colour is detected
     * The default is static::WHITE
     *
     * @param string $defaultValue an RGB colour value as a 'valid simple colour'
     */
    public function setDefaultValue(string $defaultValue) : self
    {
        $this->defaultValue = $this->getValidRGB($defaultValue);
        return $this;
    }

    /**
     * Get the current default value
     */
    public function getDefaultValue() : string
    {
        return $this->defaultValue;
    }

    /**
     * Base on the value return either the defaultValue colour value or the value
     * @return string
     * @param string $value the value to check
     * @param Validator $validator optional, see isValidRGB
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
    public function getValidRGB(?string $value, Validator $validator = null) : string
    {

        $simpleColourValue = $this->defaultValue ?? static::WHITE;

        if(!$value) {
            // no value provided .. return the defaultValue if set or WHITE
            return $simpleColourValue;
        }

        $value = strtolower($value);
        if(!$this->isValidRGB($value, $validator)) {
            $value = $simpleColourValue;
        }

        // Let result be a simple color.
        return $value;
    }

    /**
     * Check if the value provided is a valid RGB value
     * @param string $value
     * @param Validator $validator an optional validator. If provided specific errors will be stored in the validator
     */
    public function isValidRGB(?string $value, Validator $validator = null) : bool {

        // Ensure a string value
        $value = $value ?? '';

        // If input is not exactly seven characters long, then return an error.
        if(mb_strlen($value) != 7) {
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
            return false;
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
            return false;
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
            return false;
        }

        // all tests pass
        return true;
    }

    /**
     * Validate this field
     *
     * @param Validator $validator
     * @return bool
     */
    public function validate($validator)
    {
        return $this->isValidRGB($this->Value(), $validator);
    }

}
