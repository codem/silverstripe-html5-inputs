<?php

namespace Codem\Utilities\HTML5;

/**
 * Min/Max handling for supporting inputs
 * @author James
 */
trait MinMax
{
    public function setMin(string $min): static
    {
        return $this->setAttribute('min', $min);
    }

    /**
     * @return mixed
     */
    public function getMin(): ?string
    {
        return $this->getAttribute('min');
    }

    public function setMax(string $max): static
    {
        return $this->setAttribute('max', $max);
    }

    /**
     * @return mixed
     */
    public function getMax(): ?string
    {
        return $this->getAttribute('max');
    }

}
