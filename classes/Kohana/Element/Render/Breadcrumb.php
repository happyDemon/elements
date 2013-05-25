<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Renders a breadcrumb based on the active Element item
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Maxim Kerstens <admin@happydemon.org>
 * @package hD/elements
 * @copyright (c) 2013, happyDemon
 * @property string classes
 */
class Kohana_Element_Render_Breadcrumb extends Kohana_Element_Render
{

	/**
	 * View filename to use when auto-detect fails
	 */
	public $_template_dir = 'breadcrumb';

	/**
	 * @return string HTML
	 */
	public function render()
	{
		$active_tree = $this->_element->get_tree_index(Request::current()->route());
		$tree = array();

		if($active_tree != false)
		{
			$items = count($active_tree);
			$tree[] = $this->_element->get_item($active_tree[0]);

			for($i=1;$i<$items;$i++)
			{
				$tree[] = $tree[$i-1]->siblings[$active_tree[$i]];
			}

			$tree[$items-1]->last();
		}

		$this->_view->set('tree', $tree);
		$this->_view->set('element', $this->_element);
		return $this->_view->render();
	}
}
