<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.plugin.plugin');
if(JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ganalytics'.DS.'helper'.DS.'ganalytics.php')) {
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_ganalytics'.DS.'helper'.DS.'ganalytics.php');
}

class plgSystemGAnalytics extends JPlugin{

	public function onAfterRoute() {
		if(!class_exists('GAnalyticsHelper')) {
			return;
		}

		if(JFactory::getApplication()->isAdmin() && JRequest::getVar('option', null) != 'com_ganalytics'){
			return;
		}

		if($this->params->get('load-jquery', 1) == 0 || JFactory::getDocument()->getType() != 'html'){
			return;
		}

		if($this->params->get('load-jquery', 1) == 2 && JRequest::getVar('option', null) != 'com_ganalytics'){
			return;
		}

		JHTML::_('behavior.mootools');

		JFactory::getDocument()->addScript("/GAJQYLIB");

		JFactory::getApplication()->set('jQuery', true);
		JFactory::getApplication()->set('jquery', true);
	}

	public function onAfterRender() {
		if(!class_exists('GAnalyticsHelper')) {
			return;
		}

		if (JFactory::getDocument()->getType() != 'html') {
			return;
		}

		if($this->params->get('load-jquery', 1) == 1 || $this->params->get('load-jquery', 1) == 2){
			$load = true;
			if(JFactory::getApplication()->isAdmin() && JRequest::getVar('option', null) != 'com_ganalytics'){
				$load = false;
			}
			if($this->params->get('load-jquery', 1) == 2 && JRequest::getVar('option', null) != 'com_ganalytics'){
				$load = false;
			}

			if($load) {
				$body = JResponse::getBody();

				$body = preg_replace("#([\\\/a-zA-Z0-9_:\.-]*)jquery([0-9\.-]|min|pack)*?.js#", "", $body);
				$body = str_ireplace('<script src="" type="text/javascript"></script>', "", $body);
				$body = preg_replace("#/GAJQYLIB#", JURI::root().'administrator/components/com_ganalytics/libraries/jquery/jquery.min.js', $body);

				JResponse::setBody($body);
			}
		}

		if($this->params->get('load-tr-code', 1) == 0) {
			return;
		}
		if(JFactory::getApplication()->isAdmin() && $this->params->get('load-tr-code', 1) != 2) {
			return;
		}

		$groups = $this->params->get('user-groups', array());

		if(count(array_intersect(JFactory::getUser()->groups, $groups)) > 0) {
			return;
		}

		$model = JModel::getInstance('Profiles', 'GAnalyticsModel');
		$model->setState('ids', $this->params->get('accountids', null));
		$results = $model->getItems();
		if(!empty($results)){
			$tracking = $this->params->get('tracking');
			$hostname = $this->params->get('hostname');

			foreach ($results as $result) {
				$script = "\n<script type=\"text/javascript\">";
				$script .= "\nvar _gaq = _gaq || [];";
				$script .= "\n"."_gaq.push(['_setAccount', '".$result->webPropertyId."']);";
				if ($tracking == 'subdomains') {
					$script .= "\n"."_gaq.push(['_setDomainName', '.".$hostname."']);";
				} else if ($tracking == 'tld') {
					$script .= "\n"."_gaq.push(['_setDomainName', 'none']);";
					$script .= "\n"."_gaq.push(['_setAllowLinker', true]);";
				}
				$script .= "\n"."_gaq.push(['_trackPageview']);";
				$script .= "\n"."(function() {";
				$script .= "\n\t"."var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
				$script .= "\n\t"."ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
				$script .= "\n\t"."var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
				$script .= "\n"."})();\n</script>\n";
			}

			$buffer = JResponse::getBody();
			$buffer = preg_replace ("/<\/head>/", $script."</head>", $buffer);
			JResponse::setBody($buffer);
		}
	}
}