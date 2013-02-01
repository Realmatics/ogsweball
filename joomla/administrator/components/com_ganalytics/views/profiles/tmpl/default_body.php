<?php
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item){?>
	<tr class="row<?php echo $i % 2; ?>">

		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<a href="<?php echo JRoute::_( 'index.php?option=com_ganalytics&task=profile.edit&id='. $item->id ); ?>">
				<?php echo $item->profileName; ?>
			</a>
		</td>
		<td><?php echo $item->accountName; ?></td>
		<td><?php echo $item->startDate; ?></td>
		<td><?php echo $item->accountID; ?></td>
		<td><?php echo $item->profileID; ?></td>
		<td><?php echo $item->webPropertyId; ?></td>
	</tr>
<?php } ?>