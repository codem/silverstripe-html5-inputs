<?php

namespace Codem\Utilities\HTML5;

/**
 * Provides a time field, limited to hour and minute selection only
 */
class TimeField extends DateField {

    protected $inputType = 'time';

    protected $datetime_format = "H:i";

    protected $example = "14:45";

}
