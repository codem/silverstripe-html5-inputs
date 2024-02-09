<?php

namespace Codem\Utilities\HTML5;

trait Step
{

    public function setStep($step)
    {
        return $this->setAttribute('step', $step);
    }

    public function getStep()
    {
        return $this->getAttribute('step');
    }

}
