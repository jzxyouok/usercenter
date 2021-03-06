<?php
/**
 * CExtController class file.
 *
 * @author 
 * @link 
 * @copyright 
 * @license 
 */


/**
 * CExtController is the base class for controllers distributed as extension.
 *
 * The main purpose of CExtController is to redefine the {@link viewPath} property
 * so that it points to the "views" subdirectory under the directory containing
 * the controller class file.
 *
 * @property string $viewPath The directory containing the view files for this controller.
 *
 * @author 
 * @package system.web
 * @since 1.0
 */
class CExtController extends CController
{
	private $_viewPath;

	/**
	 * Returns the directory containing view files for this controller.
	 * This method overrides the parent implementation by specifying the view path
	 * to be the "views" subdirectory under the directory containing the controller
	 * class file.
	 * @return string the directory containing the view files for this controller.
	 */
	public function getViewPath()
	{
		if($this->_viewPath===null)
		{
			$class=new ReflectionClass(get_class($this));
			$this->_viewPath=dirname($class->getFileName()).DIRECTORY_SEPARATOR.'views';
		}
		return $this->_viewPath;
	}

	/**
	 * @param string $value the directory containing the view files for this controller.
	 */
	public function setViewPath($value)
	{
		$this->_viewPath=$value;
	}
}
