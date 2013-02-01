<?php

/*------------------------------------------------------------------------
# com_checkinitemsfrontend
# ------------------------------------------------------------------------
# Jacarlin Web Studio
# copyright Copyright (C) 2012 jacarlin.com.my. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.jacarlin.com.my
# Technical Support:  Forum - http://www.jacarlin.com.my/forum/
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

// Set some global property
$document = JFactory::getDocument();


// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_checkinitemsfrontend'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
JLoader::register('CheckinitemsfrontendHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'checkinitemsfrontend.php');

// Get an instance of the controller prefixed by checkinitemsfrontend
$controller = JController::getInstance('checkinitemsfrontend');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
