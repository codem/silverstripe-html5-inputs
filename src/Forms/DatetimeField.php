<?php

namespace Codem\Utilities\HTML5;

/**
 * Provides a datetime-local field, which is basically the same as a DateField
 * but with hour and minute selection
 * @author James
 */
class DatetimeField extends DateField
{

    protected $inputType = 'datetime-local';

    protected $datetime_format = "Y-m-d\TH:i";

    protected $example = "2020-12-31T14:45";

}
