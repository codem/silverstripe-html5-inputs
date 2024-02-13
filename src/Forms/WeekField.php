<?php

namespace Codem\Utilities\HTML5;

/**
 * Provides a week field
 * MDN: <input> elements of type week create input fields allowing easy entry of a
 * year plus the ISO 8601 week number during that year (i.e., week 1 to 52 or 53).
 * @author James
 */
class WeekField extends DateField
{

    /**
     * @inheritdoc
     */
    protected $inputType = 'week';

    /**
     * @var string
     */
    protected $datetime_format = "Y-\WW";

    /**
     * @var string
     */
    protected $example = "2020-W53";

}
