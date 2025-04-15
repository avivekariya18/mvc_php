<?php
class Admin_Block_Html_Elements_Boolean
{
    protected $_data = [];

    public function __construct($data)
    {
        $this->_data = $data;
    }

    public function render()
    {
        $html = "<select ";
        if (isset($this->_data['id'])) {
            $html .= sprintf("id='%s' ", htmlspecialchars($this->_data['id']));
        }
        if (isset($this->_data['name'])) {
            $html .= sprintf("name='%s' ", htmlspecialchars($this->_data['name']));
        }
        $html .= ">";

        // Add Yes/No options
        $selectedValue = $this->_data['value'] ?? '';
        $options = [
            '1' => 'Yes',
            '0' => 'No'
        ];

        foreach ($options as $value => $label) {
            $selected = ($selectedValue == $value) ? 'selected' : '';
            $html .= sprintf("<option value='%s' %s>%s</option>", htmlspecialchars($value), $selected, htmlspecialchars($label));
        }

        $html .= "</select>";

        return $html;
    }
}
