<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
require_once JPATH_COMPONENT.'/helpers/route.php';
require_once JPATH_COMPONENT.'/helpers/query.php';

// code cleaner for xhtml transitional compliance
    //$row->introtext = str_replace( '<br>', '<br />', $row->introtext );
    //$row->fulltext     = str_replace( '<br>', '<br />', $row->fulltext );
    //$row->fulltext = '<p></p>'.    $row->fulltext;
	//$row->fulltext     = str_replace( 'e', 'a', $row->fulltext );

$controller = JControllerLegacy::getInstance('Content');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
