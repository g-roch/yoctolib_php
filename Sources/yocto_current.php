<?php
/*********************************************************************
 *
 *  $Id: yocto_current.php 32610 2018-10-10 06:52:20Z seb $
 *
 *  Implements YCurrent, the high-level API for Current functions
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

//--- (YCurrent return codes)
//--- (end of YCurrent return codes)
//--- (YCurrent definitions)
if(!defined('Y_ENABLED_FALSE'))              define('Y_ENABLED_FALSE',             0);
if(!defined('Y_ENABLED_TRUE'))               define('Y_ENABLED_TRUE',              1);
if(!defined('Y_ENABLED_INVALID'))            define('Y_ENABLED_INVALID',           -1);
//--- (end of YCurrent definitions)
    #--- (YCurrent yapiwrapper)
   #--- (end of YCurrent yapiwrapper)

//--- (YCurrent declaration)
/**
 * YCurrent Class: Current function interface
 *
 * The Yoctopuce class YCurrent allows you to read and configure Yoctopuce current
 * sensors. It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, to access the autonomous datalogger.
 */
class YCurrent extends YSensor
{
    const ENABLED_FALSE                  = 0;
    const ENABLED_TRUE                   = 1;
    const ENABLED_INVALID                = -1;
    //--- (end of YCurrent declaration)

    //--- (YCurrent attributes)
    protected $_enabled                  = Y_ENABLED_INVALID;            // Bool
    //--- (end of YCurrent attributes)

    function __construct($str_func)
    {
        //--- (YCurrent constructor)
        parent::__construct($str_func);
        $this->_className = 'Current';

        //--- (end of YCurrent constructor)
    }

    //--- (YCurrent implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    public function get_enabled()
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ENABLED_INVALID;
            }
        }
        $res = $this->_enabled;
        return $res;
    }

    public function set_enabled($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled",$rest_val);
    }

    /**
     * Retrieves a current sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the current sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YCurrent.isOnline() to test if the current sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a current sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the current sensor
     *
     * @return YCurrent : a YCurrent object allowing you to drive the current sensor.
     */
    public static function FindCurrent($func)
    {
        // $obj                    is a YCurrent;
        $obj = YFunction::_FindFromCache('Current', $func);
        if ($obj == null) {
            $obj = new YCurrent($func);
            YFunction::_AddToCache('Current', $func, $obj);
        }
        return $obj;
    }

    public function enabled()
    { return $this->get_enabled(); }

    public function setEnabled($newval)
    { return $this->set_enabled($newval); }

    /**
     * Continues the enumeration of current sensors started using yFirstCurrent().
     *
     * @return YCurrent : a pointer to a YCurrent object, corresponding to
     *         a current sensor currently online, or a null pointer
     *         if there are no more current sensors to enumerate.
     */
    public function nextCurrent()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindCurrent($next_hwid);
    }

    /**
     * Starts the enumeration of current sensors currently accessible.
     * Use the method YCurrent.nextCurrent() to iterate on
     * next current sensors.
     *
     * @return YCurrent : a pointer to a YCurrent object, corresponding to
     *         the first current sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCurrent()
    {   $next_hwid = YAPI::getFirstHardwareId('Current');
        if($next_hwid == null) return null;
        return self::FindCurrent($next_hwid);
    }

    //--- (end of YCurrent implementation)

};

//--- (YCurrent functions)

/**
 * Retrieves a current sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the current sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YCurrent.isOnline() to test if the current sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a current sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the current sensor
 *
 * @return YCurrent : a YCurrent object allowing you to drive the current sensor.
 */
function yFindCurrent($func)
{
    return YCurrent::FindCurrent($func);
}

/**
 * Starts the enumeration of current sensors currently accessible.
 * Use the method YCurrent.nextCurrent() to iterate on
 * next current sensors.
 *
 * @return YCurrent : a pointer to a YCurrent object, corresponding to
 *         the first current sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstCurrent()
{
    return YCurrent::FirstCurrent();
}

//--- (end of YCurrent functions)
?>