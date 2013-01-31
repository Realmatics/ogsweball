<?php
/**
 * @version    $Id: mod_jgerman.php 41 2009-09-22 22:29:24Z sisko1990 $
 * @author     Jan Erik Zassenhaus (www.jgerman.de)
 * @copyright  Copyright (C) 2005 - 2009 Open Source Matters. All rights reserved.
 * @copyright  Copyright (C) 2009 Jan Erik Zassenhaus. All rights reserved.
 *
 * BugFix: Uwe Walter (admin@joomlakom.de)
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die( 'Restricted access' );

// Include the helper code only once
require_once(dirname(__FILE__).DS.'helper.php');

// Create the class
$helper = new modJGermanHelper($params);

// Define some variables, so we can work easier
$server = $helper->getAvailable();

// Include our default layout
require(JModuleHelper::getLayoutPath('mod_jgerman'));
?>