<?php

namespace Codem\Utilities\HTML5;

/**
 * Core common attribute methods
 * @author James
 */
trait Core
{
    /**
     * Convert a boolean value to a string for use in an attribute value
     * Any value provided in that resolves to true will return 'true'
     */
    protected function bool2str($value): string
    {
        return $value ? 'true' : 'false';
    }

    /**
     *  Set spellcheck attribute value
     */
    public function setSpellcheck($spellcheck): static
    {
        if ($spellcheck === "") {
            return $this->setAttribute('spellcheck', '');
        } else {
            return $this->setAttribute('spellcheck', $this->bool2str($spellcheck));
        }
    }

    /**
     *  Get spellcheck attribute value
     */
    public function getSpellcheck(): ?string
    {
        return $this->getAttribute('spellcheck');
    }

}
