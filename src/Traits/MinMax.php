<?php

namespace Codem\Utilities\HTML5;

trait MinMax {

    public function setMin($min) {
        return $this->setAttribute('min', $min);
    }

    public function getMin() {
        return $this->getAttribute('min');
    }

    public function setMax($max) {
        return $this->setAttribute('max', $max);
    }

    public function getMax() {
        return $this->getAttribute('max');
    }

}
