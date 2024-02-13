<?php

namespace Codem\Utilities\HTML5;

/**
 * Provides a datetime-local field, which is basically the same as a DateField
 * but with hour and minute selection
 * @author James
 */
class DatetimeField extends DateField
{

    /**
     * @inheritdoc
     */
    protected $inputType = 'datetime-local';

    /**
     * @var string
     * The browser will always send the datetime in this format
     */
    protected $datetime_format = "Y-m-d\TH:i";

    /**
     * @var string
     */
    protected $example = "2020-12-31T14:45";

}
