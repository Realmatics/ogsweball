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

class CheckinitemsfrontendHelper
{
	

	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;		
		$assetName = 'checkinitemsfrontend';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
