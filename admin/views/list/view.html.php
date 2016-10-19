<?php

defined('_JEXEC') or exit();


class Dmnd_seoViewList extends JViewLegacy {

	protected $items;
	protected $pagination;

	public function display($tpl = null) {

		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		$this->addToolbar();

		$this->loadHelper( 'dmnd_seo' );
		dmnd_seoHelper::addSubmenu( 'list' );
		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	protected function addToolbar() {
		JToolBarHelper::title(JText::_('SITEMAP'));

		// JToolBarHelper::addNew('item.add', 'Добавить url');
		// JToolBarHelper::editList('item.edit');
		// JToolBarHelper::deleteList('', 'list.delete');
		// JToolBarHelper::apply('item.savemap', 'Сохранить');
		JToolBarHelper::apply('list.generatemap', 'Генерировать');
	}

	protected function setDocument() {
		$document = JFactory::getDocument();
	}
}