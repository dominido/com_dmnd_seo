<?php

defined('_JEXEC') or exit();

?>

<form action="index.php?option=com_dmnd_seo&view=list" method="post" id="adminForm" name="adminForm">

	<?php if (!empty( $this->sidebar )) { ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php } else { ?>
		<div id="j-main-container">
			<?php } ?>

			<table class="table table-stripped table-hover">
				<thead>
					<tr>
						<th width="1%"><?php echo JText::_('#'); ?></th>
						<!-- <th width="2%"><?php echo JHtml::_('grid.checkall'); ?></th> -->
						<th width="40%"><?php echo JText::_('URL'); ?></th>
						<th width="10%"><?php echo JText::_('lastmod'); ?></th>
						<th width="10%"><?php echo JText::_('changefreq'); ?></th>
						<th width="10%"><?php echo JText::_('priority'); ?></th>
						<!-- <th width="5%"><?php echo JText::_('PUBLISHED'); ?></th> -->
						<th width="5%"><?php echo JText::_('ID'); ?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<td colspan="6">
							<div class="pagination">
								<?php echo $this->pagination->getLimitBox(); ?>
								<?php echo $this->pagination->getListFooter(); ?>
							</div>
						</td>
					</tr>
				</tfoot>

				<tbody>
					<?php if(!empty($this->items)) { ?>
						<?php foreach($this->items as $i=>$row) { ?>
							<?php $link = 'index.php?option=com_dmnd_seo&task=item.edit&id='.$row->id; ?>
							<tr>
								<td><?php echo $this->pagination->getRowOffset($i); ?></td>
								<!-- <td><?php echo JHtml::_('grid.id', $i, $row->id); ?></td> -->
								<td>
									<a target="_blank" href="<?php echo $row->url; ?>">
										<?php echo $row->url; ?>
									</a>
								</td>
								<td align="center"><?php  echo $row->lastmod; ?></td>
								<td align="center"><?php  echo $row->changefreq; ?></td>
								<td align="center"><?php  echo $row->priority; ?></td>
								<!-- <td align="center"><?php echo JHtml::_('jgrid.published', $row->published, $i, 'list.', true); ?></td> -->
								<td align="center"><?php  echo $row->id; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value="">
			<input type="hidden" name="boxchecked" value="">
			<?php echo JHtml::_('form.token'); ?>

		</div>

</form>