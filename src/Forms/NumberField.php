<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\NumericField;

/**
 * Numeric input field
 */
class NumberField extends NumericField {

    use Core;
    use Datalist;
    use Step;
    use MinMax;

    protected $inputType = 'number';

    /**
     * Validates for numeric value
     *
     * @param Validator $validator
     *
     * @return boolean
     */
    public function validate($validator)
    {
        $this->value = trim($this->value);

        if (!is_numeric($this->value)) {
            $validator->validationError(
                $this->name,
                _t('Codem\\Utilities\\HTML5\\NumberField.VALIDATION', 'Please enter a number value'),
                'validation'
            );
            return false;
        }
        return true;
    }

}
