<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GAnalyticsViewProfile extends JView{

	public function display($tpl = null){
		$form = $this->get('Form');
		$profile = $this->get('Item');

		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$this->form = $form;
		$this->profile = $profile;

		$isNew = $profile->id < 1;

		JToolBarHelper::title(JText::_('COM_GANALYTICS_PROFILE_VIEW_TITLE'), 'analytics');

		JRequest::setVar('hidemainmenu', true);
		$canDo = GAnalyticsHelper::getActions();
		if ($canDo->get('core.edit')){
			// We can save the new record
			JToolBarHelper::apply('profile.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('profile.save', 'JTOOLBAR_SAVE');
		}
		JToolBarHelper::cancel('profile.cancel', 'JTOOLBAR_CLOSE');

		parent::display($tpl);
	}
}
