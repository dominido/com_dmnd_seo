<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldOnepic extends JFormField
{

	protected $type = 'Onepic';


	public function getInput()
	{

                $style = '
                        .onepic img{
                                max-width: 200px;
                                border: solid 2px #000;
                        }
                ';

                JFactory::getDocument()->addStyleDeclaration( $style );

                $value = $this->value;

                if ($value) {

                        $folder = $this->element['folder'];

                        $path = JURI::root() . $folder;
                        $html = '<input type="file" name="'.$this->name.'" id="'.$this->name.'" accept="image/*" size="10" aria-invalid="false">';
                        $html .= '<div class="onepic"><img src="'.$path.''.$this->value.'"></div>';
                        $html .= '<input type="hidden" name="onepic" value="'.$this->value.'">';

                } else {

                        $html = '<input type="file" name="'.$this->name.'" id="'.$this->name.'" accept="image/*" size="10" aria-invalid="false">';

                }

		return $html;
	}

        // public function getLabel() {
        //         $html = $this->element['label'];

        //         return $html;
        // }
}
