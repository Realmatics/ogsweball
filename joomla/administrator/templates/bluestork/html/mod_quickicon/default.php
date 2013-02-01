<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
JFactory::getLanguage()->load('override');
$a=count($buttons);

$a++;
					$buttons[($a)]=array(					
						'link' => JRoute::_('http://opengeosys.org/administrator/index.php?option=com_ganalytics'),
						'image' => 'header/48-analytics.png',
						'text' => JText::_('Google Analytics'),
						'access' => array('core.manage', 'com_content', 'core.create', 'com_content', )
					); 
					
//for ($c = $i; $c <= $a; $c++)
//{unset($buttons[($c)]);}
			
$html = JHtml::_('icons.buttons', $buttons);
?>
<?php if (!empty($html)): ?>
	<div class="cpanel"><?php echo $html;?></div>
<?php endif;?>
