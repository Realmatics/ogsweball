<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GAnalyticsViewPage extends JView {

	public function display($tpl = null) {
		$this->profiles = $this->get('Profiles');
		$this->state = $this->get('State');
		$this->entry = $this->get('Entry');

		JToolBarHelper::title(JText::_('COM_GANALYTICS_PAGE_VIEW_TITLE'), 'analytics');
		parent::display($tpl);
	}
}