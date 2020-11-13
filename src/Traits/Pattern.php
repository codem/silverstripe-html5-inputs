<?php

namespace Codem\Utilities\HTML5;

trait Pattern {

    /**
     * Set a string pattern value for the pattern attribute
     * @param string $id optional datalist id attribute
     * @return FormField
     */
    public function setPattern(string $pattern) {
        $this->setAttribute('pattern', $pattern);
        return $this;
    }

    public function getPattern() {
        return $this->getAttribute('pattern');
    }

}
