<?php
defined('_JEXEC') or die('Restricted Access');
?><tr>
	<th width="5"><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_ID') ?></th>
	<th width="20"><input type="checkbox" name="toggle" value=""
		onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
	<th><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_PROFILE_NAME') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_ACCOUNT_NAME') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_START_DATE') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_ACCOUNT_ID') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_PROFILE_ID') ?></th>
	<th><?php echo JText::_('COM_GANALYTICS_PROFILE_FIELD_WEB_PROFILE_ID') ?></th>
</tr>