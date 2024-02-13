<?php

namespace Codem\Utilities\HTML5;

/**
 * Min/Max handling for supporting inputs
 * @author James
 */
trait MinMax
{

    public function setMin($min) : self
    {
        return $this->setAttribute('min', $min);
    }

    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->getAttribute('min');
    }

    public function setMax($max) : self
    {
        return $this->setAttribute('max', $max);
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->getAttribute('max');
    }

}
