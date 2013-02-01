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

jimport('joomla.application.component.view');

class CheckinitemsfrontendViewCheckinitemsfrontend extends JView
{
	public function display($tpl = null) 
	{
	
		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function addToolBar() 
	{
    $canDo = CheckinitemsfrontendHelper::getActions();
		JToolBarHelper::title('MANAGE CHECK WEBSITE', 'check');
    if ($canDo->get('core.admin'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_checkinitemsfrontend');
		}
		
	}

	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle('MANAGE CHECK WEBSITE');
	}
}
