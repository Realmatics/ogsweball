<?php
defined('_JEXEC') or die('Restricted Access');
?><tr>
	<td colspan="8">
		<?php echo $this->pagination->getListFooter(); ?>

		<br/><br/>
		<div align="center" style="clear: both">
			<?php echo sprintf(JText::_('COM_GANALYTICS_FOOTER'), JRequest::getVar('GANALYTICS_VERSION'));?>
		</div>
	</td>
</tr>
