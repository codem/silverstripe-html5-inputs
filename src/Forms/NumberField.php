<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\TextField;

/**
 * Number input field
 * @author James
 */
class NumberField extends TextField
{
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
     * @return bool
     */
    #[\Override]
    public function validate($validator)
    {
        $value = trim($this->Value() ?? '');
        if ($value === '') {
            // empty values are valid
            return true;
        } elseif (!is_numeric($value)) {
            $validator->validationError(
                $this->name,
                _t('Codem\\Utilities\\HTML5\\NumberField.VALIDATION', 'Please enter a number value'),
                'validation'
            );
            return false;
        } else {
            return true;
        }
    }

}
