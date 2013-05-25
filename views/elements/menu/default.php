<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sample menu template.
 * Simplest case, supports only single-level menus.
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Ando Roots <ando@sqroot.eu>
 * @since 3.0
 * @package hD/elements
 * @copyright (c) 2012, Ando Roots
 */
?>
<nav>
	<ul>
		<?foreach ($menu->get_visible_items() as $item):

		if ($item->has_siblings()):?>

		<li class="dropdown  <?=$item->get_classes()?>" title="<?=$item->tooltip?>">
			<?=$item->title?>
			<ul>
				<?foreach ($item->siblings as $subitem): ?>
				<li>
					<?=(string) $subitem?>
				</li>
				<? endforeach?>
			</ul>
		</li>

		<? else:
		// No, this is a "normal", single-level menu
		?>
		<li class="<?=$item->get_classes()?>">
			<?=(string) $item?>
		</li>

		<? endif;

		 endforeach?>
	</ul>
</nav>