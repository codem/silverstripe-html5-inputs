<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\TextField;

/**
 * Provides a date field
 * @author James
 */
class DateField extends TextField {

    use Core;
    use Datalist;
    use Step;
    use MinMax;

    protected $inputType = 'date';

    protected $datetime_format = "Y-m-d";

    protected $example = "2020-12-31";

    protected function formatDate(\Datetime $datetime) {
        return $datetime->format( $this->datetime_format );
    }

    public function setMin(\DateTime $min) {
        return $this->setAttribute('min', $this->formatDate($min));
    }

    public function setMax(\DateTime $max) {
        return $this->setAttribute('max', $this->formatDate($max));
    }

    /**
     * Validates for date value in format specified
     *
     * @param Validator $validator
     *
     * @return boolean
     */
    public function validate($validator)
    {
        try {
            $this->value = trim($this->value);
            $dt = new \Datetime($this->value);
            $formatted = $this->formatDate($dt);
            if($formatted != $this->value) {
                throw new \Exception("Invalid date value passed");
            }
            return true;
        } catch (\Exception $e) {
            $validator->validationError(
                $this->name,
                sprintf(
                    _t(
                        'Codem\\Utilities\\HTML5\\DateField.VALIDATION',
                        'Please enter a valid date in the format {format} (example:{example})',
                        [
                            'format' => $this->datetime_format,
                            'example' => $this->example
                        ]
                    )
                ),
                'validation'
            );
            return false;
        }
    }

}
