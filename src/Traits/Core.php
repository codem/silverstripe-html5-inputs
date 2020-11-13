<?php

namespace Codem\Utilities\HTML5;

trait Core {

    protected function bool2str($value) {
        return $value ? 'true' : 'false';
    }

    public function setSpellcheck($spellcheck) {
        return $this->setAttribute('spellcheck', $this->bool2str($spellcheck));
    }

    public function getSpellcheck() {
        return $this->getAttribute('spellcheck');
    }

}
