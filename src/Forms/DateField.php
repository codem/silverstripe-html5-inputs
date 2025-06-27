<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\TextField;

/**
 * Provides a date field
 * @author James
 */
class DateField extends TextField
{
    use Core;
    use Datalist;
    use Step;
    use MinMax;

    /**
     * @inheritdoc
     */
    protected $inputType = 'date';

    /**
     * @var string
     */
    protected $datetime_format = "Y-m-d";

    /**
     * @var string
     */
    protected $example = "2020-12-31";

    /**
     * Format a date based on the field's formatr string
     */
    protected function formatDate(\Datetime $datetime): string
    {
        return $datetime->format($this->datetime_format);
    }

    /**
     * Set minimum accepted date
     */
    public function setMin(\DateTime $min): static
    {
        return $this->setAttribute('min', $this->formatDate($min));
    }

    /**
     * Set maximum accepted date
     */
    public function setMax(\DateTime $max): static
    {
        return $this->setAttribute('max', $this->formatDate($max));
    }

    #[\Override]
    public function validate(): ValidationResult
    {
        try {
            $validationResult = parent::validate();
            $value = trim($this->getValue() ?? '');
            if ($value === '') {
                // empty values are valid
                return $validationResult;
            }

            $dt = new \Datetime($value);
            $formatted = $this->formatDate($dt);
            if ($formatted !== $value) {
                throw new \Exception("Invalid date value passed");
            }

            return $validationResult;
        } catch (\Exception) {
            $validationResult->addFieldError(
                $this->name,
                _t(
                    'Codem\\Utilities\\HTML5\\DateField.VALIDATION',
                    'Please enter a valid date in the format {format} (example:{example})',
                    [
                        'format' => $this->datetime_format,
                        'example' => $this->example
                    ]
                ),
                ValidationResult::TYPE_ERROR
            );
            return $validationResult;
        }
    }

}
