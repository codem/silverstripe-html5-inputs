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

    public function getMin(): ?string
    {
        return $this->getAttribute('min');
    }

    public function setMax(string $max): static
    {
        return $this->setAttribute('max', $max);
    }

    public function getMax(): ?string
    {
        return $this->getAttribute('max');
    }

}
