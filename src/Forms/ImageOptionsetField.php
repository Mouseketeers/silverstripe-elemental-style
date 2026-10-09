<?php

namespace Jellygnite\ElementalStyle\Forms;

use SilverStripe\Model\ArrayData;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\OptionsetField;


class ImageOptionsetField extends OptionsetField
{
	protected $objects = null;
	
	public function __construct($name, $title = null, $source = [], $value = null, $objects = [])
    {
        if ($source) {
            $this->objects = $objects;
        }		
        parent::__construct($name, $title, $source, $value);
    }
	 
	protected function getFieldOption($value, $title, $odd, $object = null)
    {
        return new ArrayData([
            'ID' => $this->getOptionID($value),
            'Class' => $this->getOptionClass($value, $odd) . ($object ? ' hasobject': '' ),
            'Role' => 'option',
            'Name' => $this->getOptionName(),
            'Value' => $value,
            'Title' => $title,
            'isChecked' => $this->isSelectedValue($value, $this->getFormattedValue()),
            'isDisabled' => $this->isDisabledValue($value),
			'Object' => $object
        ]);
    }
	
    public function Field($properties = [])
    {
        $options = [];
        $odd = false;

        // Add all options striped
		$index = 0;
        foreach ($this->getSourceEmpty() as $value => $title) {
            $odd = !$odd;
			$object = $this->objects[$title];
//			Debug::show($object );
            $options[] = $this->getFieldOption($value, $title, $odd, $object);
			$index++;
        }

        $properties = array_merge($properties, [
            'Options' => new ArrayList($options)
        ]);

        return FormField::Field($properties);
    }
}
