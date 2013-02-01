<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class GAnalyticsViewTools extends JView {
	
	public function display($tpl = null) {
		JToolBarHelper::title(JText::_('COM_GANALYTICS_TOOLS_VIEW_TITLE'), 'analytics');
		JToolBarHelper::preferences('com_ganalytics', 240);
		parent::display($tpl);
	}
}