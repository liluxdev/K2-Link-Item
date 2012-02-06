<?php
/*------------------------------------------------------------------------

# plg_linkitem - Link item plugin for K2

# ------------------------------------------------------------------------

# author    Jiliko.net

# copyright Copyright (C) 2011 Jiliko.net. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.jiliko.net

# Technical Support:  Forum - http://www.jiliko.net/forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die ('Restricted access');
?>

<div class="K2LinkedItemContainer">
	<?php foreach($linkedItems as $linkedItem): ?>
	<div id="item-linkitem-<?php echo $linkedItem->id; ?>" class="linkedItemView">
		<?php if ($pluginParams->get('linkedItemImage') && $linkedItem->image): ?>
		<div class="linkedItemImage">
			<?php if ($pluginParams->get('linkedItemImageAsLink') && $linkedItem->link): ?>
			<a href="<?php echo $linkedItem->link; ?>">
			<?php endif;?>
			<img src="<?php echo $linkedItem->image; ?>" />
			<?php if ($pluginParams->get('linkedItemImageAsLink') && $linkedItem->link): ?>
			</a>
			<?php endif;?>
		</div>
		<?php endif; ?>
		<?php if ($pluginParams->get('linkedItemTitle')): ?>
		<div class="linkedItemTitle">
			<?php if ($pluginParams->get('linkedItemTitleAsLink') && $linkedItem->link): ?>
			<a href="<?php echo $linkedItem->link; ?>">
			<?php endif;?>
			<?php echo $linkedItem->title; ?>
			<?php if ($pluginParams->get('linkedItemTitleAsLink') && $linkedItem->link): ?>
			</a>
			<?php endif;?>
		</div>
		<?php endif; ?>
		<?php if ($pluginParams->get('linkedItemIntroText')): ?>
		<div class="linkedItemIntroText">
			<?php echo $linkedItem->introtext; ?>
		</div>
		<?php endif; ?>
		<?php if ($pluginParams->get('linkedItemFullText')): ?>
		<div class="linkedItemFullText">
			<?php echo $linkedItem->fulltext; ?>
		</div>
		<?php endif; ?>
		<?php if ($pluginParams->get('linkedItemReadMore') && $linkedItem->link): ?>
		<div class="linkedItemReadMore">
			<a href="<?php echo $linkedItem->link; ?>"><?php echo JText::_('Read more...'); ?></a>
		</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
	<div class="clr"></div>
</div>