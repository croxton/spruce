<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Spruce extension class
 *
 * @package		Spruce
 * @author		Mark Croxton
 * @copyright	Copyright (c) 2016, hallmarkdesign
 * @link		https://github.com/croxton/spruce
 * @since		1.0
 * @filesource 	./system/user/addons/spruce/ext.spruce.php
 */
class Spruce_ext {
		
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = array())
	{
		// required extension properties
		$this->name				= 'Spruce';
		$this->version			= '1.0.0';
		$this->description		= 'Spruce up the control panel with some minor CSS tweaks';
		$this->settings_exist	= 'n';
	}

	// ------------------------------------------------------

	/**
	 * Activate Extension
	 * 
	 * @return void
	 */
	public function activate_extension()
	{
		 $this->_add_hook('cp_css_end', 10);
	}

	// ------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * @return void
	 */
	public function disable_extension()
	{
		ee()->db->where('class', __CLASS__);
		ee()->db->delete('extensions');
	}
	
	// ------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * @param 	string	String value of current version
	 * @return 	mixed	void on update / FALSE if none
	 */
	public function update_extension($current = '')
	{
		if ($current == '' OR (version_compare($current, $this->version) === 0))
		{
			return FALSE; // up to date
		}

		// update table row with current version
		ee()->db->where('class', __CLASS__);
		ee()->db->update('extensions', array('version' => $this->version));
	}

	// ------------------------------------------------------
    // 
    /**
     * Method for cp_css_end hook
     *
     * Add custom CSS to every Control Panel page:
     *
     * @access     public
     * @param      array
     * @return     array
     */
    public function cp_css_end()
    {
    	return file_get_contents( PATH_THIRD . '/spruce/css/cp.css');
    }

	// --------------------------------------------------------------------

    /**
     * Add extension hook
     *
     * @access     private
     * @param      string
     * @param      integer
     * @return     void
     */
    private function _add_hook($name, $priority = 10)
    {
        ee()->db->insert('extensions',
            array(
                'class'    => __CLASS__,
                'method'   => $name,
                'hook'     => $name,
                'settings' => '',
                'priority' => $priority,
                'version'  => $this->version,
                'enabled'  => 'y'
            )
        );
    }
	
}