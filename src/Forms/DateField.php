<?php

namespace Codem\Utilities\HTML5;

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

    /**
     * Validates for date value in format specified
     *
     * @param \SilverStripe\Forms\Validator $validator
     *
     * @return bool
     */
    #[\Override]
    public function validate($validator)
    {
        try {
            $value = trim($this->Value() ?? '');
            if ($value === '') {
                // empty values are valid
                return true;
            }

            $dt = new \Datetime($value);
            $formatted = $this->formatDate($dt);
            if ($formatted !== $value) {
                throw new \Exception("Invalid date value passed");
            }

            return true;
        } catch (\Exception) {
            $validator->validationError(
                $this->name,
                _t(
                    'Codem\\Utilities\\HTML5\\DateField.VALIDATION',
                    'Please enter a valid date in the format {format} (example:{example})',
                    [
                        'format' => $this->datetime_format,
                        'example' => $this->example
                    ]
                ),
                'validation'
            );
            return false;
        }
    }

}
