<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\TextField;

/**
 * From <input> elements of type tel are used to let the user enter and edit a telephone number.
 * @author James
 */
class TelField extends TextField
{

    use Core;
    use Datalist;
    use Pattern;
    use MinMax;

    protected $inputType = 'tel';

    /**
     * @inheritdoc
     */
    public function Type()
    {
        return 'tel text';
    }

    /**
     * There is no current spec for validating a phone number
     * You should add your own validation routine to your form handling

     * TODO: use libphonenumber to validate the number?
     *
     * @inheritdoc
     */
    public function validate($validator)
    {
        return parent::validate($validator);
    }
}
