<?php

namespace Concrete\Package\AttributeMultiText\Attribute\MultiText;

use Loader,
    Concrete\Core\Attribute\DefaultController as DefaultAttributeTypeController;

class Controller extends DefaultAttributeTypeController
{

    protected $searchIndexFieldDefinition = array('type' => 'text', 'options' => array('notnull' => false));

    public function type_form()
    {
        $this->load();
    }

    public function load()
    {
        $this->set('form', Loader::helper('form'));

        $ak = $this->getAttributeKey();
        $db = Loader::db();

        if (is_object($ak)) {
            $row = $db->GetRow('SELECT fields, showLabels FROM atMultiText WHERE akID = ?',
                array($ak->getAttributeKeyID()));
            foreach ($row as $item => $value) {
                $this->set($item, $value);
            }
        }
    }

    public function getDisplaySanitizedValue()
    {
        return $this->getDisplayValue();
    }

    public function getDisplayValue()
    {
        $this->load();
        $fields = unserialize($this->get('fields'));
        $output = '';
        if (is_array($fields)) {
            $value = $this->getValue();
            foreach ($fields['handle'] as $key => $item) {
                if ($this->get('showLabels')) {
                    $output .= $fields['name'][$key] . ': ' . $value[$item] . '<br>';
                } else {
                    $output .= $value[$item] . '<br>';
                }
            }
        }
        return $output;
    }

    public function saveKey($data)
    {
        $ak = $this->getAttributeKey();
        $db = Loader::db();

        $db->Replace('atMultiText', [
            'akID' => $ak->getAttributeKeyID(),
            'showLabels' => $data['showLabels'] ? 1 : 0,
            'fields' => serialize($data['fields']),
        ], ['akID'], true);
    }

    public function saveValue($data)
    {
        parent::saveValue(serialize($data));
    }

    public function saveForm($data)
    {
        $this->saveValue($data);
    }

    public function getValue()
    {
        return unserialize(parent::getValue());
    }

    public function form()
    {
        $this->set('value', $this->getValue());

        $this->load();
    }

    public function exportKey($akey)
    {
        $this->load();
        $fields = unserialize($this->get('fields'));
        if (is_array($fields)) {
            $xmlFields = $akey->addChild('fields');
            foreach ($fields['handle'] as $key => $item) {
                $xmlField = $xmlFields->addChild('field');
                $xmlField->addAttribute('handle', $item);
                $xmlField->addAttribute('name', $fields['name'][$key]);
            }
        }
        $akey->addAttribute('show_labels', $this->get('showLabels'));
        return $akey;
    }

    public function importKey($akey)
    {
        $data = [];
        $data['showLabels'] = $akey['show_labels'];
        if (isset($akey->fields)) {
            $arr = [];
            foreach ($akey->fields->field as $field) {
                $arr['handle'][] = (string)$field['handle'];
                $arr['name'][] = (string)$field['name'];
            }
            $data['fields'] = $arr;
        }
        $this->saveKey($data);
    }

    public function composer()
    {
        $this->form();
    }

}
