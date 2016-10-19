<?php

defined('_JEXEC') or exit();

class Dmnd_seoModelList extends JModelList {

	protected function getListQuery() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('a.*');
		$query->from('#__dmnd_sitemap as a');

		return $query;
	}
  
}