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
<div class="K2CatLinkedItemContainer">
	<?php foreach($linkedItems as $linkedItem): ?>
	<div id="linkitem-<?php echo $linkedItem->id; ?>" class="catLinkedItemView">
		<?php if ($this->params->get('catLinkedItemImage') && $linkedItem->image): ?>
		<div class="catLinkedItemImage">
			<?php if ($this->params->get('catLinkedItemImageAsLink') && $linkedItem->link): ?>
			<a href="<?php echo $linkedItem->link; ?>">
			<?php endif;?>
			<img src="<?php echo $linkedItem->image; ?>" />
			<?php if ($this->params->get('catLinkedItemImageAsLink') && $linkedItem->link): ?>
			</a>
			<?php endif;?>
		</div>
		<?php endif; ?>
		<?php if ($this->params->get('catLinkedItemTitle')): ?>
		<div class="catLinkedItemTitle">
			<?php if ($this->params->get('catLinkedItemTitleAsLink') && $linkedItem->link): ?>
			<a href="<?php echo $linkedItem->link; ?>">
			<?php endif;?>
			<?php echo $linkedItem->title; ?>
			<?php if ($this->params->get('catLinkedItemTitleAsLink') && $linkedItem->link): ?>
			</a>
			<?php endif;?>
		</div>
		<?php endif; ?>
		<?php if ($this->params->get('catLinkedItemIntroText')): ?>
		<div class="catLinkedItemIntroText">
			<?php echo $linkedItem->introtext; ?>
		</div>
		<?php endif; ?>
		<?php if ($this->params->get('catLinkedItemFullText')): ?>
		<div class="catLinkedItemFullText">
			<?php echo $linkedItem->fulltext; ?>
		</div>
		<?php endif; ?>
		<?php if ($this->params->get('catLinkedItemReadMore') && $linkedItem->link): ?>
		<div class="catLinkedItemReadMore">
			<a href="<?php echo $linkedItem->link; ?>"><?php echo JText::_('Read more...'); ?></a>
		</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
	<div class="clr"></div>
</div>