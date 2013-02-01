<?php
/**
 * @package		GAnalytics
 * @author		Digital Peak http://www.digital-peak.com
 * @copyright	Copyright (C) 2012 Digital Peak, All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();
?>
<?php foreach($this->items as $i => $item){?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->profileID); ?>
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][id]" value="<?php echo $item->accountID;?>" />
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][profile]" value="<?php echo $item->profileID;?>" />
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][property]" value="<?php echo $item->webPropertyId;?>" />
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][name]" value="<?php echo base64_encode($item->accountName);?>" />
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][profileName]" value="<?php echo base64_encode($item->profileName);?>" />
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][startDate]" value="<?php echo base64_encode($item->startDate);?>" />
			<input type="hidden" name="accounts[<?php echo $item->profileID;?>][token]" value="<?php echo base64_encode($item->token);?>" />
		</td>
		<td><?php echo $item->accountName; ?></td>
		<td><?php echo $item->profileName; ?></td>
		<td><?php echo $item->accountID; ?></td>
		<td><?php echo $item->profileID; ?></td>
		<td><?php echo $item->webPropertyId; ?></td>
	</tr>
<?php } ?>