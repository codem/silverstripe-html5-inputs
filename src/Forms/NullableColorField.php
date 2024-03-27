<?php

namespace Codem\Utilities\HTML5;

use Silverstripe\Forms\CheckboxField;
use Silverstripe\Forms\CompositeField;
use Silverstripe\Forms\ReadonlyField;
use Silverstripe\Forms\FieldList;
use SilverStripe\ORM\DataObjectInterface;

/**
 * Provides a composite field that adds a colour field
 * and a checkbox to set an option for "no colour provided"
 *
 * Use this field if you allow a "no colour selection" option
 */
class NullableColorField extends CompositeField
{


    /**
     * @var ColorField|null
     */
    protected $colourField = null;

    /**
     * @var ColorField|null
     */
    protected $checkboxField = null;

    /**
     * @var string
     */
    protected $checkboxLabel = '';

    /**
     * @var array
     */
    protected $colourValue = [];

    /**
     * @var bool
     */
    protected $isSubmittingValue = false;

    /**
     * Nullable Colour Field creation
     *
     * @param string $name
     * @param string $title
     * @param string $value
     */
    public function __construct($name, $title = null, $value = null)
    {

        // Base setup before buildFields is called
        $this->setName($name);
        $this->setTitle($title);
        $this->setValue($value);

        $this->children = $this->buildFields();
        parent::__construct($this->children);

        // Ensure name/title set after main field created
        $this->setName($name);
        $this->setTitle($title);
    }

    /**
     * Return a prefixed field name
     */
    public function getPrefixedFieldName(string $suffix) : string {
        $fieldName = $this->getName() . "[{$suffix}]";
        return $fieldName;
    }

    /**
     * Get the checkbox field
     */
    public function getCheckboxField() : CheckboxField {
        return $this->checkboxField;
    }

    /**
     * Get the colour field
     */
    public function getColourField() : ColorField {
        return $this->colourField;
    }

    /**
     * This field has data
     */
    public function hasData()
    {
        return true;
    }

    /**
     * @inheritdoc
     * @param array $value
     */
    public function setSubmittedValue($value, $data = null)
    {
        $this->isSubmittingValue = true;
        return parent::setSubmittedValue($value, $data);
    }

    /**
     * @inheritdoc
     * When Form::loadDataFrom() is called, the value is set, child fields need to be set
     * when this occurs
     */
    public function setValue($value, $data = null)
    {
        $noValue = true;
        $colourValue = '';
        if(is_array($value)) {
            // value is being submitted
            $this->isSubmittingValue = true;
            $colourValue = isset($value['colour']) && is_string($value['colour']) ? $value['colour'] : '';
            $noValue = isset($value['none']) && $value['none'] == 1;
        } else if(is_string($value)) {
            $colourValue = $value;
            $noValue = ($colourValue == '');
        }

        // Determine setting of value
        if($noValue) {
            $colourValue = '';
        }

        $this->colourValue = [
            'colour' => $colourValue,
            'none' => $noValue ? 1 : 0
        ];

        // Create fields with the values found
        $this->buildFields();

        return parent::setValue($value, $data);
    }

    /**
     * Create fields and return them
     * Note that setValue sets colourValue
     */
    protected function buildFields() : FieldList {

        // set up colour field
        $this->colourField = ColourField::create(
            $this->getPrefixedFieldName('colour'),
            '', // title is set on the main field not the colour field
             $this->colourValue['colour']
        );

        // set up checkbox field
        $this->checkboxField = CheckboxField::create(
            $this->getPrefixedFieldName('none'),
            _t(
                'Codem\\Utilities\\HTML5\\NullableColorField.NO_COLOUR_LABEL',
                'None'
            ),
            $this->colourValue['none']
        );

        $fields = FieldList::create(
            $this->colourField,
            $this->checkboxField
        );

        return $fields;
    }

    /**
     * Save the data value into the record
     * @inheritdoc
     */
    public function saveInto(DataObjectInterface $record)
    {
        $dataValue = $this->dataValue();
        return parent::saveInto($record);
    }

    /**
     * Get the data value, which will either be null, if no string is
     */
    public function dataValue() {
        $noValue = $this->checkboxField->dataValue();
        $colourValue = $this->colourField->dataValue();
        if($noValue == 1) {
            $this->value = "";
        } else {
            $this->value = $colourValue;
        }
        return $this->value;
    }

    /**
     * @inheritdoc
     * Set child fields to be disabled as well
     */
    public function setDisabled($disabled)
    {
        foreach($this->children as $child) {
            $child->setDisabled($disabled);
        }
        return parent::setDisabled($disabled);
    }

    /**
     * @inheritdoc
     * Set child fields to be readonly as well
     */
    public function setReadonly($readonly)
    {
        foreach($this->children as $child) {
            $child->setReadonly($readonly);
        }
        return parent::setReadonly($readonly);
    }

    /**
     * The readonly version of this field
     */
    public function performReadonlyTransformation()
    {
        $value = $this->Value();
        $field = ReadonlyField::create(
            $this->getName(),
            $this->Title(),
            $value
        );
        $field->setDescription( $this->getDescription() );
        $field->setRightTitle( $this->RightTitle() );
        return $field;
    }


}
