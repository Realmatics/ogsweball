<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GAnalyticsViewPages extends JView {

	public function display($tpl = null) {
		$this->profiles = $this->get('Profiles');
		$this->state = $this->get('State');
		$this->entries = $this->get('Entries');
		$this->pagination = $this->get('Pagination');

		$this->addToolBar();

		parent::display($tpl);
	}

	private function addToolBar() {
		JToolBarHelper::title(JText::_('COM_GANALYTICS_PAGES_VIEW_TITLE'), 'analytics');
		$canDo = GAnalyticsHelper::getActions();
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_ganalytics', 500);
		}
	}
}