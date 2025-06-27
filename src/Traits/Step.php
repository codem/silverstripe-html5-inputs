<?php

namespace Codem\Utilities\HTML5;

trait Step
{
    /**
     * set step attribute value
     */
    public function setStep($step): static
    {
        return $this->setAttribute('step', $step);
    }

    /**
     * get step attribute value
     */
    public function getStep()
    {
        return $this->getAttribute('step');
    }

}
