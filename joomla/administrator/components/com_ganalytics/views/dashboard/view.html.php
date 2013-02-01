<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GAnalyticsViewDashboard extends JView {

	public function display($tpl = null) {
		$this->statsViews = $this->get('StatsViews');
		$this->groups = $this->get('Groups');
		$this->profiles = $this->get('Profiles');

		$this->addToolBar();

		parent::display($tpl);
	}

	private function addToolBar() {
		JToolBarHelper::title(JText::_('COM_GANALYTICS_DASHBOARD_VIEW_TITLE'), 'analytics');
		$canDo = GAnalyticsHelper::getActions();
		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('dashboard.reset', 'purge.png', 'purge.png', JText::_('COM_GANALYTICS_PROFILES_VIEW_DASHBOARD_RESET_BUTTON'), false);
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_ganalytics', 500);
		}
	}
}