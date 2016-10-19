<?php

defined('_JEXEC') or exit();

class Dmnd_seoViewItem extends JViewLegacy {

	protected $form;
	protected $item;

	public function display($tpl = null) {

		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$this->addToolbar();

		parent::display($tpl);
	}

	protected function addToolbar() {
		JToolBarHelper::title(JText::_('NEW_SITEMAP_ITEM'));
		JToolBarHelper::apply('item.apply');
		JToolBarHelper::save('item.save');
		JToolBarHelper::cancel('item.cancel');
	}

	protected function setDocument() {
		$document = JFactory::getDocument();
	}
}