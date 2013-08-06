<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Represents a single element item (typically a link) in the Element.
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Ando Roots <ando@sqroot.eu>, Maxim Kerstens <admin@happydemon.org>
 * @package hD/elements
 * @copyright (c) 2012, Ando Roots
 */
class Kohana_Element_Item
{

	/**
	 * @var array Current item config
	 */
	private $_config = array();

	/**
	 * @var Element Reference to the items parent element
	 */
	private $_element;

	/**
	 * @param array $item_config Element item config
	 * @param \Element $element The Element where this item belongs
	 * @param int   $index contains the current item's index
	 */
	public function __construct(array $item_config, Element $element, $index)
	{
		$this->_config = self::get_default_config();
		$this->_element = $element;

		// Save item config options. Defaults are retained if not present in $item_config
		$this->_config = array_replace($this->_config, $item_config, ['items' => []]);

		// Translate visible strings
		$this->_config['title'] = __($this->_config['title']);
		$this->_config['tooltip'] = __($this->_config['tooltip']);

		// Add icon to the title
		if (! empty($this->_config['icon'])) {
			$this->_config['title'] = $this->_render_icon().$this->_config['title'];
		}

		// Apply URL::site
		if(isset($this->_config['route'])) {
			$route_params = (isset($this->_config['param'])) ? $this->_config['param'] : array();
			$this->_config['url'] = URL::site(Route::get($this->_config['route'])->uri($route_params), true);
			$this->_element->routes[$this->_config['route']] = $index;
		}
		else if (! 'http://' == substr($this->_config['url'], 0, 7)    AND ! 'https://' == substr($this->_config['url'], 0, 8)) {
			$this->_config['url'] = URL::site($this->_cornfig['url']);
		}

		// Sub-Element
		if (array_key_exists('items', $item_config) && count($item_config['items']) > 0) {
			foreach ($item_config['items'] as $key => $sibling) {
				$this->_config['siblings'][$key] = new Element_Item($sibling, $element, $index.'.'.$key);
			}
		}
	}

	/**
	 * @return string HTML anchor
	 */
	public function __toString()
	{
		if($this->last == true)
		{
			return $this->_config['title'];
		}
		else
		{
			return HTML::anchor(
				$this->_config['url'],
				$this->_config['title'],
				array(
					'title' => $this->_config['tooltip']
				),
				NULL,
				FALSE
			);
		}
	}

	/**
	 * @return bool Whether the current Element item has siblings (sub-items)
	 */
	public function has_siblings()
	{
		return count($this->_config['siblings']) > 0;
	}

	/**
	 * @return bool Whether the current Element item has a link
	 */
	public function has_link()
	{
		return ($this->_config['url'] != '#');
	}

	/**
	 * Add a CSS class to the current item
	 *
	 * @param string $class
	 * @return Kohana_Element_Item
	 */
	public function add_class($class)
	{
		if (! in_array($class, $this->_config['classes'])) {
			$this->_config['classes'][] = $class;
		}
		return $this;
	}

	/**
	 * Remove a CSS class from the current Element item
	 *
	 * @param string $class
	 * @return Kohana_Element_Item
	 */
	public function remove_class($class)
	{
		$key = array_search($class, $this->_config['classes']);
		if ($key !== FALSE) {
			unset($this->_config['classes'][$key]);
		}
		return $this;
	}

	/**
	 * Check if the Element item is visible (rendered).
	 * Use case example: can be used to hide the admin link from unauthorized users.
	 *
	 * @return bool True if the item is visible
	 */
	public function is_visible()
	{
		return $this->_config['visible'];
	}

	/**
	 * Access Element item config
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->_config)) {
			return $this->_config[$name];
		}
	}

	/**
	 *
	 * Mark this element item as last for breadcrumbs
	 */
	public function last()
	{
		$this->_config['last'] = true;
	}

	/**
	 * @return string HTML for the link icon
	 */
	private function _render_icon()
	{
		return '<i class="'.$this->_config["icon"].'"></i> ';
	}

	/**
	 * @return array
	 */
	public static function get_default_config()
	{
		return [
			'classes'  => array(), // Extra classes for this Element item
			'icon'     => NULL, // Icon class for this Element item
			'siblings' => array(), // Sub-links
			'title'    => NULL, // Visible text
			'tooltip'  => NULL, // Tooltip text for this Element item
			'url'      => '#', // Relative or absolute target for this Element item (href)
			'visible'  => TRUE
		];
	}

	/**
	 * Get classes applied to this item.
	 * This includes the active class (if present) and additional classes set by the user
	 *
	 * @return string Space-separated list of CSS classes
	 */
	public function get_classes()
	{
		return implode(' ', $this->_config['classes']);
	}
}
