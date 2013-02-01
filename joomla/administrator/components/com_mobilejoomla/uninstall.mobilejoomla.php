<?php
/**
 * Mobile Joomla!
 * http://www.mobilejoomla.com
 *
 * @version		1.2.2
 * @license		GNU/GPL v2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @copyright	(C) 2008-2012 Kuneri Ltd.
 * @date		December 2012
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__).'/classes/mjinstaller.php';

function com_install()
{
	return MjInstaller::install();
}

function com_uninstall()
{
	return MjInstaller::uninstall();
}