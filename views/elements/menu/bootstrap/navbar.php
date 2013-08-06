<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Navigation item template for Twitter Bootstrap main navbar.
 * Render the output inside div.navbar>div.navbar-inner>.container
 *
 * @link http://twitter.github.com/bootstrap/components.html#navbar
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Ando Roots <ando@sqroot.eu>
 * @since 2.0
 * @package hD/elements
 * @copyright (c) 2012, Ando Roots
 */
?>
<ul class="nav">

	<?foreach ($menu->get_visible_items() as $item):

	// Is this a dropdown-menu with sibling links?
	if ($item->has_siblings()):?>

		<li class="dropdown <?=$item->get_classes();?>" title="<?=$item->tooltip?>">
			<a href="#"
			   class="dropdown-toggle"
			   data-toggle="dropdown"><?=$item->title?><b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<?foreach ($item->siblings as $subitem): ?>
				<li class="<?=$subitem->get_classes();?>">
					<?=(string) $subitem?>
				</li>
				<? endforeach?>
			</ul>
		</li>

		<? else:
		// No, this is a "normal", single-level menu
		?>
		<li class="<?=$item->get_classes();?>">
			<?=(string) $item?>
		</li>

		<? endif ?>

	<? endforeach?>
</ul>