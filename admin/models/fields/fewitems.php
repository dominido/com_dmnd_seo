<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldFewitems extends JFormField
{

	protected $type = 'Fewitems';


	public function getInput()
	{
                $script = '
                        jQuery(document).ready(function($){

                                $("#add_item").on("click", function(){

                                        var items_count = Number($("#items_count").val());
                                        var newCount = items_count+1;

                                        var clone = $(".controls-item .item-block:last-child").clone();
                                        clone.find("input").val("");

                                        // $("<hr>").appendTo(".controls-item");
                                        $(clone).appendTo(".controls-item");

                                        //$(".controls-item").append.clone(".controls-item .item-block:last-child");
                                        //(\'<div class="item-block">Serial <input type="text" name="catalog[serial][]"> Name <input type="text" name="catalog[name][]"> Size <input type="text" name="catalog[size][]"> Bulb <input type="text" name="catalog[bulb][]"> Color <input type="text" name="catalog[color][]"> Price <input type="text" name="catalog[price][]"> Sale Price <input type="text" name="catalog[saleprice][]"></div><hr>\');

                                        $("#items_count").val(newCount);
                                });

                        });
                ';

                JFactory::getDocument()->addScriptDeclaration( $script );

                $style = '
                        .controls-item input {
                                width: 250px;
                        }

                        .controls-item .item-block {
                                margin-bottom: 5px;
                        }

                        .controls-item hr {
                                margin: 10px 0;
                        }
                ';

                JFactory::getDocument()->addStyleDeclaration( $style );

                $value = unserialize($this->value);

                if ($value) {

                        $html = '<div class="controls-item">';
                        for ($i=0; $i < count($value); $i++) { 

                                $html .= '
                                        <div class="item-block">
                                                <input type="text" name="fewitems[]" value="'.$value[$i].'">
                                        </div>';
                        }
                        $html .= '</div>
                                <input type="hidden" name="items_count" id="items_count" value="'.$i.'">';

                } else {

                        $html = '
                        <div class="controls-item">
                                <div class="item-block">
                                        <input type="text" name="fewitems[]">
                                </div>
                        </div>
                        <input type="hidden" name="items_count" id="items_count" value="1">
                        ';

                }



		return $html;
	}

        public function getLabel() {
                $html = '
                Phone(s) <button type="button" class="btn btn-mini" id="add_item"><i class=" icon-plus"></i></button>
                ';

                return $html;
        }
}
