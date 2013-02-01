<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ganalytics'.DS.'helper'.DS.'ganalytics.php');

jimport('joomla.application.component.controller');
require_once(JPATH_COMPONENT.DS.'controller.php');

JFactory::getLanguage()->load('com_ganalytics', JPATH_ADMINISTRATOR);

$controller	= JController::getInstance('GAnalytics');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();