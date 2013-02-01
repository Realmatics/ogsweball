<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

if (!JFactory::getUser()->authorise('core.manage', 'com_ganalytics')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ganalytics'.DS.'helper'.DS.'ganalytics.php');

require_once(JPATH_COMPONENT.DS.'controller.php');
jimport('joomla.application.component.controller');

$path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ganalytics'.DS.'ganalytics.xml';
if(file_exists($path)) {
	$manifest = simplexml_load_file($path);
	JRequest::setVar('GANALYTICS_VERSION', (string)$manifest->version);
} else {
	JRequest::setVar('GANALYTICS_VERSION', '');
}

$controller = JController::getInstance('GAnalytics');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();