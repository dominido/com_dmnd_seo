<?php

defined( '_JEXEC' ) or die;

class Dmnd_seoHelper
{
	static function addSubmenu( $vName )
	{
		JHtmlSidebar::addEntry(
			JText::_( 'SITEMAP' ),
			'index.php?option=com_dmnd_seo&view=list',
			$vName == 'list' );
	}
}