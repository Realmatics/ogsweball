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

class CheckinitemsfrontendController extends JController
{
	function display($cachable = false) 
	{
		// Set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'checkinitemsfrontend'));
		
		parent::display($cachable);				
		
	}
}
