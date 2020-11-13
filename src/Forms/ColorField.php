<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\TextField;

/**
 * Provides a colour picker / field
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color
 */
class ColorField extends TextField {

    use Core;
    use Datalist;

    protected $template = "Codem/Utilities/HTML5/ColorField";

    protected $inputType = 'color';

}

/**
 * Provides a class for those of us not using en_US
 */
class ColourField extends ColorField {

    protected $template = "Codem/Utilities/HTML5/ColorField";

}
