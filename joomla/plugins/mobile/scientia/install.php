<?php
/**
 * Mobile Joomla! ScientiaMobile DBI extension
 * http://www.mobilejoomla.com
 *
 * @version		1.2-2012.10.09
 * @license		AGPL
 * @copyright	(C) 2008-2012 Kuneri Ltd.
 * @date		October 2012
 */
defined('_JEXEC') or die('Restricted access');

class plgMobileScientiaInstallerScript
{
	function preflight($type, $adapter)
	{
		$path = $adapter->getParent()->getPath('source');
		$xmldest = $path.'/scientia.xml';
		$xmlsrc = $path.'/scientia.j2x.xml';
		if(JFile::exists($xmlsrc))
		{
			if(JFile::exists($xmldest))
				JFile::delete($xmldest);
			JFile::move($xmlsrc, $xmldest);
		}
		$adapter->getParent()->setPath('manifest', $xmldest);
	}

	public function postflight($route, $installer)
	{
		require_once( JPATH_ROOT .DS.'plugins'.DS.'mobile'.DS.'scientia'.DS.'scientia'.DS.'scientia_helper.php' );

		ScientiaHelper::disablePlugin();
		switch($route)
		{
		case 'update':
		case 'install':
			$status = ScientiaHelper::installDatabase();
			if($status)
			{
				ScientiaHelper::disablePlugin('amdd');
				ScientiaHelper::enablePlugin();
			}
			break;
		case 'uninstall':
			ScientiaHelper::disablePlugin();
			ScientiaHelper::enablePlugin('amdd');
			ScientiaHelper::dropDatabase();
			break;
		}
		return true;
	}
}