<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\TextField;

/**
 * From <input> elements of type tel are used to let the user enter and edit a telephone number.
 */
class TelField extends TextField {

    use Core;
    use Datalist;
    use Pattern;
    use MinMax;

    protected $inputType = 'tel';

    /**
     * @inheritdoc
     */
    public function Type() {
        return 'text tel';
    }

    /**
     * TODO: use libphonenumber to validate the number
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
