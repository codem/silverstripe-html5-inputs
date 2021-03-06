<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\Forms\TextField;

/**
 * Search input field
 */
class SearchField extends TextField {

    use Core;
    use Datalist;
    use Pattern;

    protected $inputType = 'search';

}
