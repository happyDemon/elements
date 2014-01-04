<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Represents a single Element type HTML entity
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @author Ando Roots <ando@sqroot.eu>
 * @package hD/elements
 * @copyright (c) 2012, Ando Roots
 */
class Kohana_Element
{
	/**
	 * Element configuration is in this dir
	 *
	 * @since 2.2
	 */
	const CONFIG_DIR = 'navigation';

	/**
	 * @var array Holds current Element configuration
	 */
	protected $_config;

	/**
	 * @var array An (ordered) array of Element_Items in this Element
	 * @since 2.0
	 */
	protected $_items;

	/**
	 * @var int Reference to the currently active Element item
	 */
	protected $_active_item_index;

	/**
	 * @var string The value of the last Element item (used in breadcrumbs)
	 */
	public $last_item = null;

	/**
	 * @var array Contains a Element item -> route map
	 */
	public $routes;

	/**
	 * @var array Contains params to bind to specific routes
	 */
	public $route_params = array();

	/**
	 * Initialize a new Element.
	 * Use the factory method instead of the `new` keyword.
	 *
	 * @param array $config Element configuration, overrides default values
	 * @see self::factory
	 */
	public function __construct(array $config)
	{
		$element_items = array();
		if (array_key_exists('items', $config)) {
			$element_items = $config['items'];

			// We don't want to save this to $this->_config
			unset($config['items']);
		}

		// Save Element config, overriding default values
		$this->_config = array_replace(self::get_default_config(), $config);

		// Transform Element items from an array to objects
		$this->_build_items($element_items);
	}

	/**
	 * Transform Element items from an array to objects
	 *
	 * @since 3.0
	 * @param array $items An array of Element items
	 * @return \Kohana_Element
	 */
	private function _build_items(array $items)
	{
		foreach ($items as $key => $item) {
			$this->_items[$key] = new Element_Item($item, $this, $key);
		}

		return $this;
	}

	/**
	 * Read Element configuration file
	 *
	 * @param string $config File name in config/navigation dir
	 * @return array Element configuration array
	 * @throws Kohana_Exception
	 */
	protected static function _get_element_config($config)
	{
		if (Kohana::find_file('config'.DIRECTORY_SEPARATOR.self::CONFIG_DIR, $config) === FALSE) {
			throw new Kohana_Exception('Element configuration file ":path" not found!', [
				':path' => APPPATH.'config'.DIRECTORY_SEPARATOR.self::CONFIG_DIR.DIRECTORY_SEPARATOR.$config.EXT
			]);
		}

		return Kohana::$config->load(self::CONFIG_DIR.DIRECTORY_SEPARATOR.$config)
			->as_array();
	}

	/**
	 * Instantiate a new Element
	 *
	 * @param string $config_file File name in config/navigation/ or a Config_Group instance
	 * @throws Kohana_Exception
	 * @return Element
	 * @since 2.0
	 */
	public static function factory($config_file = 'bootstrap')
	{
		if(is_a($config_file, 'Config_Group')) {
			$config_file->set('cfg_name', $config_file->group_name());
			$element_config = $config_file->as_array();
		}
		else {
			// Load element config
			$element_config = self::_get_element_config($config_file);
			$element_config['cfg_name'] = $config_file;
		}


		return new Element($element_config);
	}

	/**
	 * Render the Element into HTML
	 *
	 * @since 2.0
	 * @return string the rendered view
	 */
	public function render($driver='Menu', $tpl=null, $active_recursive=false)
	{
		// Try to guess the current active Element item
		if ($this->_active_item_index === NULL)
		{
			$this->set_current(Route::name(Request::$initial->route()), $active_recursive);
		}

		return Kohana_Element_Render::factory($driver, $this, $tpl)->render();
	}

	/**
	 * @since 1.0
	 * @see render()
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}

	/**
	 * Set the title of the last value of a breadcrumb element
	 *
	 * @param $value string The value of the last item when rendering in breadcrumb
	 * @return Kohana_Element
	 */
	public function last_item($value) {
		$this->last_item = $value;

		return $this;
	}

	/**
	 * Get an array of Element_Item instances
	 *
	 * @since 2.0
	 * @return array
	 */
	public function get_items()
	{
		return $this->_items;
	}

	/**
	 * Get only visible Element items
	 *
	 * @return array
	 */
	public function get_visible_items()
	{
		if ($this->_items === NULL) {
			return array();
		}

		$visible_items = [];

		foreach ($this->_items as $key => $item)
		{
			if (! $item->is_visible())
			{
				continue;
			}
			$visible_items[$key] = $item;
		}

		return $visible_items;
	}

	/**
	 * Set the currently active Element item (by applying the `active_item_class` CSS class)
	 *
	 * @param int|string $id The ID of the Element (numerical array ID from the config file) or route of a Element item
	 * @param boolean $recursive Should parent items also be set active?
	 * @return Element_Item|bool The active Element item or FALSE when item not found
	 */
	public function set_current($id = 0, $recursive=false)
	{
		$active_item = $this->get_item($id);

		if (! $active_item)
			return FALSE;

		$this->_active_item_index = $this->routes[$id];
		$active_item->set_active($this->_config['active_item_class'], $recursive);

		return $active_item;
	}


	/**
	 * Access Element config properties
	 *
	 * @param string $name Name of a Element config property
	 * @return mixed
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->_config))
			return $this->_config[$name];

		return NULL;
	}

	/**
	 * Get an instance of Element_Item based on its ID
	 *
	 * @param int|string $id Item ID or route name
	 * @return bool|Element_Item
	 */
	public function get_item($id)
	{
		// Element empty!
		if (count($this->_items) === 0)
			return FALSE;

		if (array_key_exists($id, $this->_items))
		{ // By ID
			return $this->_items[$id];
		} else
		{ // By route
			$path = $this->get_tree_index(Route::get($id));

			if($path != false)
			{
				$levels = count($path);

				$item = $this->_items[$path[0]];

				if($levels > 1)
				{
					for($i=1; $i<$levels; $i++)
					{
						$item = $item->siblings[$path[$i]];
					}
				}
				return $item;
			}
		}
		return FALSE;
	}

	/**
	 * Return an array to traverse to possibly get sibling items based on a given route
	 *
	 * @param Route $route
	 * @return array|bool
	 */
	public function get_tree_index(Route $route)
	{
		$name = Route::name($route);

		if(isset($this->routes[$name]))
			return explode('.', $this->routes[$name]);

		return false;
	}

	/**
	 * @return array Default configuration for the Element
	 */
	public static function get_default_config()
	{
		return [
			'active_item_class' => 'active'
		];
	}
}