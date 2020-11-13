<?php

namespace Codem\Utilities\HTML5;

trait Pattern {

    /**
     * Set whether an input can accept multiple values
     * @param bool $multiple when false, the attribute is removed
     * @return FormField
     */
    public function setMultiple(bool $multiple) {
        if($multiple) {
            $this->setAttribute('multiple', 'multiple');
        } else {
            unset($this->attributes['multiple']);
        }
        return $this;
    }

    public function getMultiple() {
        return $this->getAttribute('multiple');
    }

}
