<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Renders the HTML for a Menu
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Maxim Kerstens <admin@happydemon.org>
 * @package hD/elements
 * @copyright (c) 2013, happyDemon
 * @property string classes
 */
class Kohana_Element_Render_Menu extends Kohana_Element_Render
{

	/**
	 * View filename to use when auto-detect fails
	 */
	public $_template_dir = 'menu';

	/**
	 * @return string HTML
	 */
	public function render()
	{
		$this->_view->set('menu', $this->_element);
		return $this->_view->render();
	}
}
