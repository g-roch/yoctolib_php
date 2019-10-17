<?php
/*********************************************************************
 *
 *  $Id: yocto_voltage.php 35360 2019-05-09 09:02:29Z mvuilleu $
 *
 *  Implements YVoltage, the high-level API for Voltage functions
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

//--- (YVoltage return codes)
//--- (end of YVoltage return codes)
//--- (YVoltage definitions)
if(!defined('Y_ENABLED_FALSE'))              define('Y_ENABLED_FALSE',             0);
if(!defined('Y_ENABLED_TRUE'))               define('Y_ENABLED_TRUE',              1);
if(!defined('Y_ENABLED_INVALID'))            define('Y_ENABLED_INVALID',           -1);
//--- (end of YVoltage definitions)
    #--- (YVoltage yapiwrapper)
   #--- (end of YVoltage yapiwrapper)

//--- (YVoltage declaration)
/**
 * YVoltage Class: Voltage function interface
 *
 * The Yoctopuce class YVoltage allows you to read and configure Yoctopuce voltage
 * sensors. It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, to access the autonomous datalogger.
 */
class YVoltage extends YSensor
{
    const ENABLED_FALSE                  = 0;
    const ENABLED_TRUE                   = 1;
    const ENABLED_INVALID                = -1;
    //--- (end of YVoltage declaration)

    //--- (YVoltage attributes)
    protected $_enabled                  = Y_ENABLED_INVALID;            // Bool
    //--- (end of YVoltage attributes)

    function __construct($str_func)
    {
        //--- (YVoltage constructor)
        parent::__construct($str_func);
        $this->_className = 'Voltage';

        //--- (end of YVoltage constructor)
    }

    //--- (YVoltage implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the activation state of this input.
     *
     * @return integer : either Y_ENABLED_FALSE or Y_ENABLED_TRUE, according to the activation state of this input
     *
     * On failure, throws an exception or returns Y_ENABLED_INVALID.
     */
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

    /**
     * Changes the activation state of this input. When an input is disabled,
     * its value is no more updated. On some devices, disabling an input can
     * improve the refresh rate of the other active inputs.
     *
     * @param integer $newval : either Y_ENABLED_FALSE or Y_ENABLED_TRUE, according to the activation
     * state of this input
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_enabled($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled",$rest_val);
    }

    /**
     * Retrieves a voltage sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the voltage sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YVoltage.isOnline() to test if the voltage sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the voltage sensor
     *
     * @return YVoltage : a YVoltage object allowing you to drive the voltage sensor.
     */
    public static function FindVoltage($func)
    {
        // $obj                    is a YVoltage;
        $obj = YFunction::_FindFromCache('Voltage', $func);
        if ($obj == null) {
            $obj = new YVoltage($func);
            YFunction::_AddToCache('Voltage', $func, $obj);
        }
        return $obj;
    }

    public function enabled()
    { return $this->get_enabled(); }

    public function setEnabled($newval)
    { return $this->set_enabled($newval); }

    /**
     * Continues the enumeration of voltage sensors started using yFirstVoltage().
     * Caution: You can't make any assumption about the returned voltage sensors order.
     * If you want to find a specific a voltage sensor, use Voltage.findVoltage()
     * and a hardwareID or a logical name.
     *
     * @return YVoltage : a pointer to a YVoltage object, corresponding to
     *         a voltage sensor currently online, or a null pointer
     *         if there are no more voltage sensors to enumerate.
     */
    public function nextVoltage()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindVoltage($next_hwid);
    }

    /**
     * Starts the enumeration of voltage sensors currently accessible.
     * Use the method YVoltage.nextVoltage() to iterate on
     * next voltage sensors.
     *
     * @return YVoltage : a pointer to a YVoltage object, corresponding to
     *         the first voltage sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVoltage()
    {   $next_hwid = YAPI::getFirstHardwareId('Voltage');
        if($next_hwid == null) return null;
        return self::FindVoltage($next_hwid);
    }

    //--- (end of YVoltage implementation)

};

//--- (YVoltage functions)

/**
 * Retrieves a voltage sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the voltage sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YVoltage.isOnline() to test if the voltage sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a voltage sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the voltage sensor
 *
 * @return YVoltage : a YVoltage object allowing you to drive the voltage sensor.
 */
function yFindVoltage($func)
{
    return YVoltage::FindVoltage($func);
}

/**
 * Starts the enumeration of voltage sensors currently accessible.
 * Use the method YVoltage.nextVoltage() to iterate on
 * next voltage sensors.
 *
 * @return YVoltage : a pointer to a YVoltage object, corresponding to
 *         the first voltage sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstVoltage()
{
    return YVoltage::FirstVoltage();
}

//--- (end of YVoltage functions)
?>