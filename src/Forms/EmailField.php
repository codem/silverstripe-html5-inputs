<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\EmailField as CoreEmailField;

/**
 * Text input field with validation for correct email format according to RFC 2822.
 * @author james
 */
class EmailField extends CoreEmailField {

    use Core;
    use Datalist;
    use Pattern;
    use Multiple;

    protected $inputType = 'email';

}
