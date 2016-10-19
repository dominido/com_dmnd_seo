<?php

defined('_JEXEC') or exit();

class Dmnd_seoTableItem extends JTable {

	public function __construct(&$db) {
		parent::__construct('#__dmnd_sitemap', 'id', $db);
	}
}