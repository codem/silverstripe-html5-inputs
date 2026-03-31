<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Core\Validation\ValidationResult;
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

    #[\Override]
    public function validate(): ValidationResult
    {
        $validationResult = parent::validate();
        $value = trim($this->getValue() ?? '');
        if ($value === '') {
            // empty values are valid
            return $validationResult;
        } elseif (!is_numeric($value)) {
            $validationResult->addFieldError(
                $this->name,
                _t('Codem\\Utilities\\HTML5\\NumberField.VALIDATION', 'Please enter a number value'),
                ValidationResult::TYPE_ERROR
            );
            return $validationResult;
        } else {
            return $validationResult;
        }
    }

}
