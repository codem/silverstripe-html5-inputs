<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\TextField;

/**
 * Range input field
 */
class RangeField extends TextField
{
    use Core;
    use Datalist;
    use Step;
    use MinMax;

    /**
     * @inheritdoc
     */
    protected $inputType = 'range';

    /**
     * @inheritdoc
     */
    public function __construct($name, $title = null, $value = null)
    {
        parent::__construct($name, $title, $value);
        // Set sensible defaults per MDN
        $this->setMin(0);
        $this->setMax(100);
        $this->setStep(1);
    }

    #[\Override]
    public function validate(): ValidationResult
    {
        $validationResult = parent::validate();
        $value = trim($this->getValue() ?? '');
        if ($value === '') {
            // empty values are valid
            return $validationResult;
        }

        if (!is_numeric($value)) {
            $validationResult->addFieldError(
                $this->name,
                _t('Codem\\Utilities\\HTML5\\RangeField.VALIDATION_NUMERIC', 'Please enter a number value'),
                ValidationResult::TYPE_ERROR
            );
            return $validationResult;
        }

        $max = $this->getMax();
        $min = $this->getMin();
        if (is_numeric($min) && is_numeric($max)) {
            $valid = $value >= $min  &&  $value <= $max;
            if (!$valid) {
                // out of range
                $validationResult->addFieldError(
                    $this->name,
                    _t(
                        'Codem\\Utilities\\HTML5\\RangeField.VALIDATION_BOUNDS',
                        'The value provided must be between {min} and {max}',
                        [
                            'min' => $min,
                            'max' => $max
                        ]
                    ),
                    ValidationResult::TYPE_ERROR
                );
            }

            return $validationResult;
        } elseif (is_numeric($min)) {
            $valid = $value >= $min;
            if (!$valid) {
                // out of range
                $validationResult->addFieldError(
                    $this->name,
                    _t(
                        'Codem\\Utilities\\HTML5\\RangeField.VALIDATION_BOUNDS',
                        'The value provided must be greater than or equal to {min}',
                        [
                            'min' => $min
                        ]
                    ),
                    ValidationResult::TYPE_ERROR
                );
            }

            return $validationResult;
        } elseif (is_numeric($max)) {
            $valid = $value <= $max;
            if (!$valid) {
                // out of range
                $validationResult->addFieldError(
                    $this->name,
                    _t(
                        'Codem\\Utilities\\HTML5\\RangeField.VALIDATION_BOUNDS',
                        'The value provided must be less than or equal to {max}',
                        [
                            'max' => $max
                        ]
                    ),
                    ValidationResult::TYPE_ERROR
                );
            }

            return $validationResult;
        } else {
            // no range restriction, numeric value is valid
            return $validationResult;
        }
    }

}
