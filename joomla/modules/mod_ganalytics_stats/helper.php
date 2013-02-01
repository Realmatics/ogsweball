<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

class ModGAnalyticsStatsHelper {

	public function getSelectedProfile(&$params){
		$model = JModel::getInstance('Profiles', 'GAnalyticsModel');
		$model->setState('ids',$params->get('accountids', null));
		$data = $model->getItems();
		if(empty($data)){
			return null;
		}
		return $data[0];
	}
}