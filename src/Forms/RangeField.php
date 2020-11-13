<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\TextField;

/**
 * Range input field
 */
class RangeField extends TextField {

    use Core;
    use Datalist;
    use Step;
    use MinMax;

    protected $inputType = 'range';

    /**
     * Validates for value within range ?
     *
     * @param Validator $validator
     *
     * @return boolean
     */
    public function validate($validator)
    {
        return true;
    }

}
