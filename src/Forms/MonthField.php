<?php

namespace Codem\Utilities\HTML5;

/**
 * Provides a month field, which is basically the same as a DateField
 * but with month and year selection
 */
class MonthField extends DateField {

    protected $inputType = 'month';

    protected $datetime_format = "Y-m";

    protected $example = "2020-12";

}
