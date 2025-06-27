<?php

namespace Codem\Utilities\HTML5;

/**
 * Datalist trait used for supporting inputs that can have a <datalist>
 * @author James
 */
trait Datalist
{
    protected ?\SilverStripe\Model\List\ArrayList $inputDatalist = null;

    protected string $inputDatalistId = '';

    /**
     * Return values  for a <datalist>
     */
    protected function createDataList(array $datalist): \SilverStripe\Model\List\ArrayList
    {
        $list = \SilverStripe\Model\List\ArrayList::create();
        foreach ($datalist as $value => $label) {
            $list->push(\SilverStripe\Model\ArrayData::create([
                'Value' => $value,
                'Label' => $label
            ]));
        }

        return $list;
    }

    /**
     * Set a list of values rendered into a <datalist> tag (HTMLDataListElement)
     * @param string $id optional datalist id attribute
     */
    public function setDatalist(array $datalist, $id = null): static
    {
        $this->inputDatalist = $this->createDataList($datalist);
        if (!$id) {
            $id = $this->ID() . "_datalist";
        }

        $this->inputDatalistId = $id;
        $this->setAttribute('list', $id);
        return $this;
    }

    public function getDatalist(): ?\SilverStripe\Model\List\ArrayList
    {
        return $this->inputDatalist;
    }

    /**
     * Return datalist id value
     */
    public function Datalist(): ?\SilverStripe\Model\List\ArrayList
    {
        return $this->getDatalist();
    }

    /**
     * Return datalist id value
     */
    public function DatalistID(): ?string
    {
        return $this->inputDatalistId;
    }

}
