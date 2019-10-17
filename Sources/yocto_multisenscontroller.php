<?php
/*********************************************************************
 *
 *  $Id: yocto_multisenscontroller.php 34975 2019-04-04 17:01:43Z seb $
 *
 *  Implements YMultiSensController, the high-level API for MultiSensController functions
 *
 *  - - - - - - - - - License information: - - - - - - - - -
 *
 *  Copyright (C) 2011 and beyond by Yoctopuce Sarl, Switzerland.
 *
 *  Yoctopuce Sarl (hereafter Licensor) grants to you a perpetual
 *  non-exclusive license to use, modify, copy and integrate this
 *  file into your software for the sole purpose of interfacing
 *  with Yoctopuce products.
 *
 *  You may reproduce and distribute copies of this file in
 *  source or object form, as long as the sole purpose of this
 *  code is to interface with Yoctopuce products. You must retain
 *  this notice in the distributed source file.
 *
 *  You should refer to Yoctopuce General Terms and Conditions
 *  for additional information regarding your rights and
 *  obligations.
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED 'AS IS' WITHOUT
 *  WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING
 *  WITHOUT LIMITATION, ANY WARRANTY OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO
 *  EVENT SHALL LICENSOR BE LIABLE FOR ANY INCIDENTAL, SPECIAL,
 *  INDIRECT OR CONSEQUENTIAL DAMAGES, LOST PROFITS OR LOST DATA,
 *  COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR
 *  SERVICES, ANY CLAIMS BY THIRD PARTIES (INCLUDING BUT NOT
 *  LIMITED TO ANY DEFENSE THEREOF), ANY CLAIMS FOR INDEMNITY OR
 *  CONTRIBUTION, OR OTHER SIMILAR COSTS, WHETHER ASSERTED ON THE
 *  BASIS OF CONTRACT, TORT (INCLUDING NEGLIGENCE), BREACH OF
 *  WARRANTY, OR OTHERWISE.
 *
 *********************************************************************/

//--- (YMultiSensController return codes)
//--- (end of YMultiSensController return codes)
//--- (YMultiSensController definitions)
if(!defined('Y_MAINTENANCEMODE_FALSE'))      define('Y_MAINTENANCEMODE_FALSE',     0);
if(!defined('Y_MAINTENANCEMODE_TRUE'))       define('Y_MAINTENANCEMODE_TRUE',      1);
if(!defined('Y_MAINTENANCEMODE_INVALID'))    define('Y_MAINTENANCEMODE_INVALID',   -1);
if(!defined('Y_NSENSORS_INVALID'))           define('Y_NSENSORS_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_MAXSENSORS_INVALID'))         define('Y_MAXSENSORS_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YMultiSensController definitions)
    #--- (YMultiSensController yapiwrapper)
   #--- (end of YMultiSensController yapiwrapper)

//--- (YMultiSensController declaration)
/**
 * YMultiSensController Class: MultiSensController function interface
 *
 * The Yoctopuce application programming interface allows you to setup a customized
 * sensor chain.
 */
class YMultiSensController extends YFunction
{
    const NSENSORS_INVALID               = YAPI_INVALID_UINT;
    const MAXSENSORS_INVALID             = YAPI_INVALID_UINT;
    const MAINTENANCEMODE_FALSE          = 0;
    const MAINTENANCEMODE_TRUE           = 1;
    const MAINTENANCEMODE_INVALID        = -1;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YMultiSensController declaration)

    //--- (YMultiSensController attributes)
    protected $_nSensors                 = Y_NSENSORS_INVALID;           // UInt31
    protected $_maxSensors               = Y_MAXSENSORS_INVALID;         // UInt31
    protected $_maintenanceMode          = Y_MAINTENANCEMODE_INVALID;    // Bool
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YMultiSensController attributes)

    function __construct($str_func)
    {
        //--- (YMultiSensController constructor)
        parent::__construct($str_func);
        $this->_className = 'MultiSensController';

        //--- (end of YMultiSensController constructor)
    }

    //--- (YMultiSensController implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'nSensors':
            $this->_nSensors = intval($val);
            return 1;
        case 'maxSensors':
            $this->_maxSensors = intval($val);
            return 1;
        case 'maintenanceMode':
            $this->_maintenanceMode = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of sensors to poll.
     *
     * @return integer : an integer corresponding to the number of sensors to poll
     *
     * On failure, throws an exception or returns Y_NSENSORS_INVALID.
     */
    public function get_nSensors()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_NSENSORS_INVALID;
            }
        }
        $res = $this->_nSensors;
        return $res;
    }

    /**
     * Changes the number of sensors to poll. Remember to call the
     * saveToFlash() method of the module if the
     * modification must be kept. It is recommended to restart the
     * device with  module->reboot() after modifying
     * (and saving) this settings
     *
     * @param integer $newval : an integer corresponding to the number of sensors to poll
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_nSensors($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nSensors",$rest_val);
    }

    /**
     * Returns the maximum configurable sensor count allowed on this device.
     *
     * @return integer : an integer corresponding to the maximum configurable sensor count allowed on this device
     *
     * On failure, throws an exception or returns Y_MAXSENSORS_INVALID.
     */
    public function get_maxSensors()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MAXSENSORS_INVALID;
            }
        }
        $res = $this->_maxSensors;
        return $res;
    }

    /**
     * Returns true when the device is in maintenance mode.
     *
     * @return integer : either Y_MAINTENANCEMODE_FALSE or Y_MAINTENANCEMODE_TRUE, according to true when
     * the device is in maintenance mode
     *
     * On failure, throws an exception or returns Y_MAINTENANCEMODE_INVALID.
     */
    public function get_maintenanceMode()
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MAINTENANCEMODE_INVALID;
            }
        }
        $res = $this->_maintenanceMode;
        return $res;
    }

    /**
     * Changes the device mode to enable maintenance and to stop sensor polling.
     * This way, the device does not automatically restart when it cannot
     * communicate with one of the sensors.
     *
     * @param integer $newval : either Y_MAINTENANCEMODE_FALSE or Y_MAINTENANCEMODE_TRUE, according to the
     * device mode to enable maintenance and to stop sensor polling
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maintenanceMode($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("maintenanceMode",$rest_val);
    }

    public function get_command()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    public function set_command($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("command",$rest_val);
    }

    /**
     * Retrieves a multi-sensor controller for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the multi-sensor controller is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YMultiSensController.isOnline() to test if the multi-sensor controller is
     * indeed online at a given time. In case of ambiguity when looking for
     * a multi-sensor controller by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the multi-sensor controller
     *
     * @return YMultiSensController : a YMultiSensController object allowing you to drive the multi-sensor controller.
     */
    public static function FindMultiSensController($func)
    {
        // $obj                    is a YMultiSensController;
        $obj = YFunction::_FindFromCache('MultiSensController', $func);
        if ($obj == null) {
            $obj = new YMultiSensController($func);
            YFunction::_AddToCache('MultiSensController', $func, $obj);
        }
        return $obj;
    }

    /**
     * Configures the I2C address of the only sensor connected to the device.
     * It is recommended to put the the device in maintenance mode before
     * changing sensor addresses.  This method is only intended to work with a single
     * sensor connected to the device, if several sensors are connected, the result
     * is unpredictable.
     * Note that the device is probably expecting to find a string of sensors with specific
     * addresses. Check the device documentation to find out which addresses should be used.
     *
     * @param integer $addr : new address of the connected sensor
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function setupAddress($addr)
    {
        // $cmd                    is a str;
        $cmd = sprintf('A%d', $addr);
        return $this->set_command($cmd);
    }

    public function nSensors()
    { return $this->get_nSensors(); }

    public function setNSensors($newval)
    { return $this->set_nSensors($newval); }

    public function maxSensors()
    { return $this->get_maxSensors(); }

    public function maintenanceMode()
    { return $this->get_maintenanceMode(); }

    public function setMaintenanceMode($newval)
    { return $this->set_maintenanceMode($newval); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of multi-sensor controllers started using yFirstMultiSensController().
     * Caution: You can't make any assumption about the returned multi-sensor controllers order.
     * If you want to find a specific a multi-sensor controller, use MultiSensController.findMultiSensController()
     * and a hardwareID or a logical name.
     *
     * @return YMultiSensController : a pointer to a YMultiSensController object, corresponding to
     *         a multi-sensor controller currently online, or a null pointer
     *         if there are no more multi-sensor controllers to enumerate.
     */
    public function nextMultiSensController()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindMultiSensController($next_hwid);
    }

    /**
     * Starts the enumeration of multi-sensor controllers currently accessible.
     * Use the method YMultiSensController.nextMultiSensController() to iterate on
     * next multi-sensor controllers.
     *
     * @return YMultiSensController : a pointer to a YMultiSensController object, corresponding to
     *         the first multi-sensor controller currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMultiSensController()
    {   $next_hwid = YAPI::getFirstHardwareId('MultiSensController');
        if($next_hwid == null) return null;
        return self::FindMultiSensController($next_hwid);
    }

    //--- (end of YMultiSensController implementation)

};

//--- (YMultiSensController functions)

/**
 * Retrieves a multi-sensor controller for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the multi-sensor controller is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YMultiSensController.isOnline() to test if the multi-sensor controller is
 * indeed online at a given time. In case of ambiguity when looking for
 * a multi-sensor controller by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the multi-sensor controller
 *
 * @return YMultiSensController : a YMultiSensController object allowing you to drive the multi-sensor controller.
 */
function yFindMultiSensController($func)
{
    return YMultiSensController::FindMultiSensController($func);
}

/**
 * Starts the enumeration of multi-sensor controllers currently accessible.
 * Use the method YMultiSensController.nextMultiSensController() to iterate on
 * next multi-sensor controllers.
 *
 * @return YMultiSensController : a pointer to a YMultiSensController object, corresponding to
 *         the first multi-sensor controller currently online, or a null pointer
 *         if there are none.
 */
function yFirstMultiSensController()
{
    return YMultiSensController::FirstMultiSensController();
}

//--- (end of YMultiSensController functions)
?>