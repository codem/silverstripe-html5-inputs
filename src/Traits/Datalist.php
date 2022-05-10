<?php

namespace Codem\Utilities\HTML5;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

/**
 * Datalist trait used for supporting inputs that can have a <datalist>
 * @author James
 */
trait Datalist {

    /**
     * @var array
     */
    protected $inputDatalist;

    /**
     * @var string
     */
    protected $inputDatalistId;

    /**
     * Return values  for a <datalist>
     */
    protected function createDataList(array $datalist) : ArrayList {
        $list = ArrayList::create();
        foreach($datalist as $value => $label) {
            $list->push( ArrayData::create([
                'Value' => $value,
                'Label' => $label
            ]) );
        }
        return $list;
    }

    /**
     * Set a list of values rendered into a <datalist> tag (HTMLDataListElement)
     * @param array $list
     * @param string $id optional datalist id attribute
     * @return FormField
     */
    public function setDatalist(array $datalist, $id = null) {
        $this->inputDatalist = $this->createDataList($datalist);
        if(!$id) {
            $id = $this->ID() . "_datalist";
        }
        $this->inputDatalistId = $id;
        $this->setAttribute('list', $id);
        return $this;
    }

    public function getDatalist() : ?ArrayList {
        return $this->inputDatalist;
    }

    /**
     * Return datalist id value
     */
    public function Datalist() : ?ArrayList {
        return $this->getDatalist();
    }

    /**
     * Return datalist id value
     */
    public function DatalistID() : ?string {
        return $this->inputDatalistId;
    }

}
