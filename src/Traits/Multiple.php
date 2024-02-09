<?php

namespace Codem\Utilities\HTML5;

/**
 * multiple handling for supporting inputs
 * @author James
 */
trait Multiple
{

    /**
     * Set whether an input can accept multiple values
     * @param bool $multiple when false, the attribute is removed
     * @return FormField
     */
    public function setMultiple(bool $multiple)
    {
        if($multiple) {
            $this->setAttribute('multiple', 'multiple');
        } else {
            unset($this->attributes['multiple']);
        }
        return $this;
    }

    public function getMultiple()
    {
        return $this->getAttribute('multiple');
    }

}
