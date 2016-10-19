<?php

defined('_JEXEC') or exit();

require_once JPATH_COMPONENT.'/helpers/dmnd_seo.php';

$controller = JControllerLegacy::getInstance('Dmnd_seo');

JFactory::getDocument()->addStyleSheet( JURI::base().'components/com_dmnd_seo/assets/style.css' );

$input = JFactory::getApplication()->input;
$task = $input->get('task', 'display');

$controller->execute($task);

$controller->redirect();