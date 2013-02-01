<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GAnalyticsViewImport extends JView {

	public function display($tpl = null) {
		JToolBarHelper::title(JText::_('COM_GANALYTICS_MANAGER_GANALYTICS'), 'analytics' );

		if (JRequest::getVar('code', null) == null) {
			header('Location: ' . GAnalyticsDataHelper::getClient()->createAuthUrl());
		} else {
			$items = $this->get('Items');
			if ($items === null) {
				$this->setLayout('login');
			} else {
				$this->assignRef('items', $items);
				$canDo = GAnalyticsHelper::getActions();
				if ($canDo->get('core.create')){
					JToolBarHelper::custom('import.save', 'new.png', 'new.png', 'add', false);
				}
				JToolBarHelper::cancel('import.cancel', 'JTOOLBAR_CANCEL');
			}
		}

		parent::display($tpl);
	}
}