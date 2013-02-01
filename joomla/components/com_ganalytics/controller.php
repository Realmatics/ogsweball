<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class GAnalyticsController extends JController {

	public function display() {
		$hiddenView = null;
		if(JRequest::getVar('view', null) == 'jsonfeed'){
			$hiddenView = 'JSONFeed';
		}

		if($hiddenView !=null){
			$document =& JFactory::getDocument();

			$viewType	= $document->getType();
			$viewName	= JRequest::getCmd( 'view', $hiddenView );
			$viewLayout	= JRequest::getCmd( 'layout', 'default' );

			$this->addViewPath($this->basePath.DS.'hiddenviews');
			$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->basePath, 'layout' => $viewLayout));
			$view->addTemplatePath($this->basePath.DS.'hiddenviews'.DS.strtolower($viewName).DS.'tmpl');
		}
		parent::display();
	}

}