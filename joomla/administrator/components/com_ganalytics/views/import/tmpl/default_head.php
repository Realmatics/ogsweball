<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();
?><tr>
	<th width="20"><input type="checkbox" name="toggle" value=""
		onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
	<th><?php echo JText::_('COM_GANALYTICS_IMPORT_VIEW_COLUMN_ACCOUNT_NAME') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_IMPORT_VIEW_COLUMN_PROFILE_NAME') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_IMPORT_VIEW_COLUMN_ACCOUNT_ID') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_IMPORT_VIEW_COLUMN_PROFILE_ID') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_IMPORT_VIEW_COLUMN_WEB_PROFILE_ID') ?></th>
</tr>