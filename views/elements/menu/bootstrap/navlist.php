<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Navigation item template for Twitter Bootstrap nav lists.
 *
 * @link http://twitter.github.com/bootstrap/components.html#navs
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Maxim kerstens <admin@happydemon.org>
 * @package hD/elements
 * @copyright (c) 2013, happyDemon
 */
?>
<ul class="nav nav-list">

	<?foreach ($menu->get_visible_items() as $item):

	// show the nav headers with their siblings
	if ($item->has_siblings()):?>

		<li class="nav-header  <?=$item->get_classes()?>" title="<?=$item->tooltip?>">
			<?=$item->title?>
		</li>
		<?foreach ($item->siblings as $subitem): ?>
			<li>
				<?=(string) $subitem?>
			</li>
		<? endforeach?>

		<? else:
			//otherwise show a divider before adding the link
		?>
			<li class="divider"></li>
			<li class="<?=$item->get_classes()?>"">
				<?=(string) $item?>
			</li>
		<? endif ?>

	<? endforeach?>
</ul>