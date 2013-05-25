<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sample breadcrumb template.
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Maxim Kerstens <admin@hapydemon.org>
 * @package hD/elements
 * @copyright (c) 2013, happyDemon
 */
?>
	<ul>
		<?foreach ($tree as $item):?>
		<li class="<?=$item->get_classes()?>">
			<? if($item->last == true && $element->last_item != null): ?>
				<?=$element->last_item?>
			<? else: ?>
				<?=(string) $item?>
			<? endif?>
		</li>
		<? endforeach?>
	</ul>