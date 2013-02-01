<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class GAnalyticsModelImport extends JModel {

	public function getItems() {
		return GAnalyticsDataHelper::getAccounts();
	}

	public function store()	{
		$cids = JRequest::getVar('cid', array(0));
		if (empty($cids)){
			return true;
		}
		$accounts = JRequest::getVar( 'accounts', array(0));
		foreach ($cids as $cid) {
			$row = $this->getTable('Profile', 'GAnalyticsTable');
			$row->id = 0;
			$row->accountID = $accounts[$cid]['id'];
			$row->profileID = $accounts[$cid]['profile'];
			$row->webPropertyId = $accounts[$cid]['property'];
			$row->accountName = $this->getDbo()->escape(base64_decode($accounts[$cid]['name']));
			$row->profileName = $this->getDbo()->escape(base64_decode($accounts[$cid]['profileName']));
			$row->token = json_decode(base64_decode($accounts[$cid]['token']))->refresh_token;
			$row->startDate = JFactory::getDate(base64_decode($accounts[$cid]['startDate']))->toSql();

			if (!$row->check()) {
				JError::raiseWarning( 500, $row->getError() );
				return false;
			}

			if (!$row->store()) {
				JError::raiseWarning( 500, $row->getError() );
				return false;
			}
		}
		return true;
	}
}