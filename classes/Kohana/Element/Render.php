<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Represents a single menu item (typically a link) in the Menu.
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Maxim Kerstens <admin@happydemon.org>
 * @since 4.0
 * @package hD/elements
 * @copyright (c) 2013, happyDemon
 * @property string classes
 */
abstract class Kohana_Element_Render
{

	static public function factory($driver, Element $element, $tpl=null)
	{
		$driver = 'Element_Render_'.$driver;

		return new $driver($element, $tpl);
	}
	/**
	 * @var View filename to use when auto-detect fails
	 */
	protected $_template = 'default';

	/**
	 * @var Sub directory where the template file is stored
	 */
	protected $_template_dir = null;

	/**
	 * Menu view files reside in this dir
	 */
	const VIEWS_DIR = 'elements';

	/**
	 * @var Element Reference to the items parent Menu
	 */
	protected $_element;

	/**
	 * @var View Menu view object
	 */
	protected $_view;

	/**
	 * @param \Element $element The element we'd want to render
	 * @param string $tpl The name of the template file you specifically want to use
	 */
	public function __construct(Element $element, $tpl=null)
	{
		$this->_element = $element;

		// Overwrite the view whether or not it's already been defined in the config
		if ($tpl != null) {
			$this->_element->view = self::VIEWS_DIR.DIRECTORY_SEPARATOR.$this->_template_dir.DIRECTORY_SEPARATOR.$tpl;
		}

		// Auto-detect view path when no view file given
		else if ($this->_element->view === null) {
			$view_file = Kohana::find_file('views/'.self::VIEWS_DIR.DIRECTORY_SEPARATOR.$this->_template_dir, $this->_element->cfg_name)
				? $this->_element->cfg_name : $this->_template;

			$this->_element->view = self::VIEWS_DIR.DIRECTORY_SEPARATOR.$this->_template_dir.DIRECTORY_SEPARATOR.$view_file;
		}
		else
		{
			$this->_element->view = self::VIEWS_DIR.DIRECTORY_SEPARATOR.$this->_template_dir.DIRECTORY_SEPARATOR.$this->_element->view;
		}

		// Load menu view (auto detected or manually specified)
		$this->_view = View::factory($this->get_view_path());
	}

	/**
	 * @return string HTML
	 */
	abstract public function render();

	/**
	 * Get the path of the view file
	 *
	 * @return string
	 */
	public function get_view_path()
	{
		return $this->_element->view ? $this->_element->view : self::VIEWS_DIR.DIRECTORY_SEPARATOR.$this->_template_dir.DIRECTORY_SEPARATOR.$this->template;
	}
}
