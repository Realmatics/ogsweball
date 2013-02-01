<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GAnalyticsViewProfiles extends JView {

	public function display($tpl = null) {
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	protected function addToolBar() {
		$canDo = GAnalyticsHelper::getActions();
		JToolBarHelper::title(JText::_('COM_GANALYTICS_PROFILES_VIEW_TITLE'), 'analytics');

		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('import.import', 'upload.png', 'upload.png', JText::_('COM_GANALYTICS_PROFILES_VIEW_IMPORT_BUTTON'), false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('profile.edit', 'JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'profiles.delete', 'JTOOLBAR_DELETE');
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_ganalytics', 500);
			JToolBarHelper::divider();
		}
	}
}