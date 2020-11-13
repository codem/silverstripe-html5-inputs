<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\TextField;

/**
 * Provides a URL input field
 */
class UrlField extends TextField {

    use Core;
    use Datalist;
    use Pattern;

    protected $template = "Codem/Utilities/HTML5/UrlField";

    protected $inputType = 'url';

    /**
     * TODO: use domain validation to validate the URL
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
