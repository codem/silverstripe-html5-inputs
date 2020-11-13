<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\ORM\ArrayList;

trait Datalist {

    /**
     * @var array
     */
    protected $input_datalist;

    /**
     * @var string
     */
    protected $input_datalist_id;

    /**
     * Set a list of values rendered into a <datalist> tag (HTMLDataListElement)
     * @param array $list
     * @param string $id optional datalist id attribute
     * @return FormField
     */
    public function setDatalist(ArrayList $list, $id = null) {
        $this->input_datalist = $list;
        if($id) {
            $this->input_datalist_id = $id;
        }
        return $this;
    }

    public function getDatalist() {
        return $this->input_datalist;
    }

    public function Datalist() {
        return $this->getDatalist();
    }

}
