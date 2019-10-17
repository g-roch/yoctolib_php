<?php
/*********************************************************************
 *
 *  $Id: yocto_powersupply.php 34115 2019-01-23 14:23:54Z seb $
 *
 *  Implements YPowerSupply, the high-level API for PowerSupply functions
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

//--- (YPowerSupply return codes)
//--- (end of YPowerSupply return codes)
//--- (YPowerSupply definitions)
if(!defined('Y_POWEROUTPUT_OFF'))            define('Y_POWEROUTPUT_OFF',           0);
if(!defined('Y_POWEROUTPUT_ON'))             define('Y_POWEROUTPUT_ON',            1);
if(!defined('Y_POWEROUTPUT_INVALID'))        define('Y_POWEROUTPUT_INVALID',       -1);
if(!defined('Y_VOLTAGESENSE_INT'))           define('Y_VOLTAGESENSE_INT',          0);
if(!defined('Y_VOLTAGESENSE_EXT'))           define('Y_VOLTAGESENSE_EXT',          1);
if(!defined('Y_VOLTAGESENSE_INVALID'))       define('Y_VOLTAGESENSE_INVALID',      -1);
if(!defined('Y_VOLTAGESETPOINT_INVALID'))    define('Y_VOLTAGESETPOINT_INVALID',   YAPI_INVALID_DOUBLE);
if(!defined('Y_CURRENTLIMIT_INVALID'))       define('Y_CURRENTLIMIT_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_MEASUREDVOLTAGE_INVALID'))    define('Y_MEASUREDVOLTAGE_INVALID',   YAPI_INVALID_DOUBLE);
if(!defined('Y_MEASUREDCURRENT_INVALID'))    define('Y_MEASUREDCURRENT_INVALID',   YAPI_INVALID_DOUBLE);
if(!defined('Y_INPUTVOLTAGE_INVALID'))       define('Y_INPUTVOLTAGE_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_VINT_INVALID'))               define('Y_VINT_INVALID',              YAPI_INVALID_DOUBLE);
if(!defined('Y_LDOTEMPERATURE_INVALID'))     define('Y_LDOTEMPERATURE_INVALID',    YAPI_INVALID_DOUBLE);
if(!defined('Y_VOLTAGETRANSITION_INVALID'))  define('Y_VOLTAGETRANSITION_INVALID', YAPI_INVALID_STRING);
if(!defined('Y_VOLTAGEATSTARTUP_INVALID'))   define('Y_VOLTAGEATSTARTUP_INVALID',  YAPI_INVALID_DOUBLE);
if(!defined('Y_CURRENTATSTARTUP_INVALID'))   define('Y_CURRENTATSTARTUP_INVALID',  YAPI_INVALID_DOUBLE);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YPowerSupply definitions)
    #--- (YPowerSupply yapiwrapper)
   #--- (end of YPowerSupply yapiwrapper)

//--- (YPowerSupply declaration)
/**
 * YPowerSupply Class: PowerSupply function interface
 *
 * The Yoctopuce application programming interface allows you to change the voltage set point,
 * the current limit and the enable/disable the output.
 */
class YPowerSupply extends YFunction
{
    const VOLTAGESETPOINT_INVALID        = YAPI_INVALID_DOUBLE;
    const CURRENTLIMIT_INVALID           = YAPI_INVALID_DOUBLE;
    const POWEROUTPUT_OFF                = 0;
    const POWEROUTPUT_ON                 = 1;
    const POWEROUTPUT_INVALID            = -1;
    const VOLTAGESENSE_INT               = 0;
    const VOLTAGESENSE_EXT               = 1;
    const VOLTAGESENSE_INVALID           = -1;
    const MEASUREDVOLTAGE_INVALID        = YAPI_INVALID_DOUBLE;
    const MEASUREDCURRENT_INVALID        = YAPI_INVALID_DOUBLE;
    const INPUTVOLTAGE_INVALID           = YAPI_INVALID_DOUBLE;
    const VINT_INVALID                   = YAPI_INVALID_DOUBLE;
    const LDOTEMPERATURE_INVALID         = YAPI_INVALID_DOUBLE;
    const VOLTAGETRANSITION_INVALID      = YAPI_INVALID_STRING;
    const VOLTAGEATSTARTUP_INVALID       = YAPI_INVALID_DOUBLE;
    const CURRENTATSTARTUP_INVALID       = YAPI_INVALID_DOUBLE;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YPowerSupply declaration)

    //--- (YPowerSupply attributes)
    protected $_voltageSetPoint          = Y_VOLTAGESETPOINT_INVALID;    // MeasureVal
    protected $_currentLimit             = Y_CURRENTLIMIT_INVALID;       // MeasureVal
    protected $_powerOutput              = Y_POWEROUTPUT_INVALID;        // OnOff
    protected $_voltageSense             = Y_VOLTAGESENSE_INVALID;       // VoltageSense
    protected $_measuredVoltage          = Y_MEASUREDVOLTAGE_INVALID;    // MeasureVal
    protected $_measuredCurrent          = Y_MEASUREDCURRENT_INVALID;    // MeasureVal
    protected $_inputVoltage             = Y_INPUTVOLTAGE_INVALID;       // MeasureVal
    protected $_vInt                     = Y_VINT_INVALID;               // MeasureVal
    protected $_ldoTemperature           = Y_LDOTEMPERATURE_INVALID;     // MeasureVal
    protected $_voltageTransition        = Y_VOLTAGETRANSITION_INVALID;  // AnyFloatTransition
    protected $_voltageAtStartUp         = Y_VOLTAGEATSTARTUP_INVALID;   // MeasureVal
    protected $_currentAtStartUp         = Y_CURRENTATSTARTUP_INVALID;   // MeasureVal
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YPowerSupply attributes)

    function __construct($str_func)
    {
        //--- (YPowerSupply constructor)
        parent::__construct($str_func);
        $this->_className = 'PowerSupply';

        //--- (end of YPowerSupply constructor)
    }

    //--- (YPowerSupply implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'voltageSetPoint':
            $this->_voltageSetPoint = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'currentLimit':
            $this->_currentLimit = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'powerOutput':
            $this->_powerOutput = intval($val);
            return 1;
        case 'voltageSense':
            $this->_voltageSense = intval($val);
            return 1;
        case 'measuredVoltage':
            $this->_measuredVoltage = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'measuredCurrent':
            $this->_measuredCurrent = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'inputVoltage':
            $this->_inputVoltage = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'vInt':
            $this->_vInt = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'ldoTemperature':
            $this->_ldoTemperature = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'voltageTransition':
            $this->_voltageTransition = $val;
            return 1;
        case 'voltageAtStartUp':
            $this->_voltageAtStartUp = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'currentAtStartUp':
            $this->_currentAtStartUp = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the voltage set point, in V.
     *
     * @param double $newval : a floating point number corresponding to the voltage set point, in V
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltageSetPoint($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("voltageSetPoint",$rest_val);
    }

    /**
     * Returns the voltage set point, in V.
     *
     * @return double : a floating point number corresponding to the voltage set point, in V
     *
     * On failure, throws an exception or returns Y_VOLTAGESETPOINT_INVALID.
     */
    public function get_voltageSetPoint()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_VOLTAGESETPOINT_INVALID;
            }
        }
        $res = $this->_voltageSetPoint;
        return $res;
    }

    /**
     * Changes the current limit, in mA.
     *
     * @param double $newval : a floating point number corresponding to the current limit, in mA
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentLimit($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentLimit",$rest_val);
    }

    /**
     * Returns the current limit, in mA.
     *
     * @return double : a floating point number corresponding to the current limit, in mA
     *
     * On failure, throws an exception or returns Y_CURRENTLIMIT_INVALID.
     */
    public function get_currentLimit()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENTLIMIT_INVALID;
            }
        }
        $res = $this->_currentLimit;
        return $res;
    }

    /**
     * Returns the power supply output switch state.
     *
     * @return integer : either Y_POWEROUTPUT_OFF or Y_POWEROUTPUT_ON, according to the power supply
     * output switch state
     *
     * On failure, throws an exception or returns Y_POWEROUTPUT_INVALID.
     */
    public function get_powerOutput()
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_POWEROUTPUT_INVALID;
            }
        }
        $res = $this->_powerOutput;
        return $res;
    }

    /**
     * Changes the power supply output switch state.
     *
     * @param integer $newval : either Y_POWEROUTPUT_OFF or Y_POWEROUTPUT_ON, according to the power
     * supply output switch state
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerOutput($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerOutput",$rest_val);
    }

    /**
     * Returns the output voltage control point.
     *
     * @return integer : either Y_VOLTAGESENSE_INT or Y_VOLTAGESENSE_EXT, according to the output voltage control point
     *
     * On failure, throws an exception or returns Y_VOLTAGESENSE_INVALID.
     */
    public function get_voltageSense()
    {
        // $res                    is a enumVOLTAGESENSE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_VOLTAGESENSE_INVALID;
            }
        }
        $res = $this->_voltageSense;
        return $res;
    }

    /**
     * Changes the voltage control point.
     *
     * @param integer $newval : either Y_VOLTAGESENSE_INT or Y_VOLTAGESENSE_EXT, according to the voltage control point
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltageSense($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltageSense",$rest_val);
    }

    /**
     * Returns the measured output voltage, in V.
     *
     * @return double : a floating point number corresponding to the measured output voltage, in V
     *
     * On failure, throws an exception or returns Y_MEASUREDVOLTAGE_INVALID.
     */
    public function get_measuredVoltage()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MEASUREDVOLTAGE_INVALID;
            }
        }
        $res = $this->_measuredVoltage;
        return $res;
    }

    /**
     * Returns the measured output current, in mA.
     *
     * @return double : a floating point number corresponding to the measured output current, in mA
     *
     * On failure, throws an exception or returns Y_MEASUREDCURRENT_INVALID.
     */
    public function get_measuredCurrent()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MEASUREDCURRENT_INVALID;
            }
        }
        $res = $this->_measuredCurrent;
        return $res;
    }

    /**
     * Returns the measured input voltage, in V.
     *
     * @return double : a floating point number corresponding to the measured input voltage, in V
     *
     * On failure, throws an exception or returns Y_INPUTVOLTAGE_INVALID.
     */
    public function get_inputVoltage()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_INPUTVOLTAGE_INVALID;
            }
        }
        $res = $this->_inputVoltage;
        return $res;
    }

    /**
     * Returns the internal voltage, in V.
     *
     * @return double : a floating point number corresponding to the internal voltage, in V
     *
     * On failure, throws an exception or returns Y_VINT_INVALID.
     */
    public function get_vInt()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_VINT_INVALID;
            }
        }
        $res = $this->_vInt;
        return $res;
    }

    /**
     * Returns the LDO temperature, in Celsius.
     *
     * @return double : a floating point number corresponding to the LDO temperature, in Celsius
     *
     * On failure, throws an exception or returns Y_LDOTEMPERATURE_INVALID.
     */
    public function get_ldoTemperature()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_LDOTEMPERATURE_INVALID;
            }
        }
        $res = $this->_ldoTemperature;
        return $res;
    }

    public function get_voltageTransition()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_VOLTAGETRANSITION_INVALID;
            }
        }
        $res = $this->_voltageTransition;
        return $res;
    }

    public function set_voltageTransition($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("voltageTransition",$rest_val);
    }

    /**
     * Changes the voltage set point at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param double $newval : a floating point number corresponding to the voltage set point at device start up
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltageAtStartUp($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("voltageAtStartUp",$rest_val);
    }

    /**
     * Returns the selected voltage set point at device startup, in V.
     *
     * @return double : a floating point number corresponding to the selected voltage set point at device startup, in V
     *
     * On failure, throws an exception or returns Y_VOLTAGEATSTARTUP_INVALID.
     */
    public function get_voltageAtStartUp()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_VOLTAGEATSTARTUP_INVALID;
            }
        }
        $res = $this->_voltageAtStartUp;
        return $res;
    }

    /**
     * Changes the current limit at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param double $newval : a floating point number corresponding to the current limit at device start up
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentAtStartUp($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentAtStartUp",$rest_val);
    }

    /**
     * Returns the selected current limit at device startup, in mA.
     *
     * @return double : a floating point number corresponding to the selected current limit at device startup, in mA
     *
     * On failure, throws an exception or returns Y_CURRENTATSTARTUP_INVALID.
     */
    public function get_currentAtStartUp()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENTATSTARTUP_INVALID;
            }
        }
        $res = $this->_currentAtStartUp;
        return $res;
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
     * Retrieves a regulated power supply for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the regulated power supply is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YPowerSupply.isOnline() to test if the regulated power supply is
     * indeed online at a given time. In case of ambiguity when looking for
     * a regulated power supply by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the regulated power supply
     *
     * @return YPowerSupply : a YPowerSupply object allowing you to drive the regulated power supply.
     */
    public static function FindPowerSupply($func)
    {
        // $obj                    is a YPowerSupply;
        $obj = YFunction::_FindFromCache('PowerSupply', $func);
        if ($obj == null) {
            $obj = new YPowerSupply($func);
            YFunction::_AddToCache('PowerSupply', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of output voltage. Any explicit voltage
     * change cancels any ongoing transition process.
     *
     * @param V_target   : new output voltage value at the end of the transition
     *         (floating-point number, representing the end voltage in V)
     * @param ms_duration : total duration of the transition, in milliseconds
     *
     * @return YAPI_SUCCESS when the call succeeds.
     */
    public function voltageMove($V_target,$ms_duration)
    {
        // $newval                 is a str;
        if ($V_target < 0.0) {
            $V_target  = 0.0;
        }
        $newval = sprintf('%d:%d', round($V_target*65536), $ms_duration);

        return $this->set_voltageTransition($newval);
    }

    public function setVoltageSetPoint($newval)
    { return $this->set_voltageSetPoint($newval); }

    public function voltageSetPoint()
    { return $this->get_voltageSetPoint(); }

    public function setCurrentLimit($newval)
    { return $this->set_currentLimit($newval); }

    public function currentLimit()
    { return $this->get_currentLimit(); }

    public function powerOutput()
    { return $this->get_powerOutput(); }

    public function setPowerOutput($newval)
    { return $this->set_powerOutput($newval); }

    public function voltageSense()
    { return $this->get_voltageSense(); }

    public function setVoltageSense($newval)
    { return $this->set_voltageSense($newval); }

    public function measuredVoltage()
    { return $this->get_measuredVoltage(); }

    public function measuredCurrent()
    { return $this->get_measuredCurrent(); }

    public function inputVoltage()
    { return $this->get_inputVoltage(); }

    public function vInt()
    { return $this->get_vInt(); }

    public function ldoTemperature()
    { return $this->get_ldoTemperature(); }

    public function voltageTransition()
    { return $this->get_voltageTransition(); }

    public function setVoltageTransition($newval)
    { return $this->set_voltageTransition($newval); }

    public function setVoltageAtStartUp($newval)
    { return $this->set_voltageAtStartUp($newval); }

    public function voltageAtStartUp()
    { return $this->get_voltageAtStartUp(); }

    public function setCurrentAtStartUp($newval)
    { return $this->set_currentAtStartUp($newval); }

    public function currentAtStartUp()
    { return $this->get_currentAtStartUp(); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of regulated power supplies started using yFirstPowerSupply().
     * Caution: You can't make any assumption about the returned regulated power supplies order.
     * If you want to find a specific a regulated power supply, use PowerSupply.findPowerSupply()
     * and a hardwareID or a logical name.
     *
     * @return YPowerSupply : a pointer to a YPowerSupply object, corresponding to
     *         a regulated power supply currently online, or a null pointer
     *         if there are no more regulated power supplies to enumerate.
     */
    public function nextPowerSupply()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindPowerSupply($next_hwid);
    }

    /**
     * Starts the enumeration of regulated power supplies currently accessible.
     * Use the method YPowerSupply.nextPowerSupply() to iterate on
     * next regulated power supplies.
     *
     * @return YPowerSupply : a pointer to a YPowerSupply object, corresponding to
     *         the first regulated power supply currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPowerSupply()
    {   $next_hwid = YAPI::getFirstHardwareId('PowerSupply');
        if($next_hwid == null) return null;
        return self::FindPowerSupply($next_hwid);
    }

    //--- (end of YPowerSupply implementation)

};

//--- (YPowerSupply functions)

/**
 * Retrieves a regulated power supply for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the regulated power supply is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YPowerSupply.isOnline() to test if the regulated power supply is
 * indeed online at a given time. In case of ambiguity when looking for
 * a regulated power supply by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the regulated power supply
 *
 * @return YPowerSupply : a YPowerSupply object allowing you to drive the regulated power supply.
 */
function yFindPowerSupply($func)
{
    return YPowerSupply::FindPowerSupply($func);
}

/**
 * Starts the enumeration of regulated power supplies currently accessible.
 * Use the method YPowerSupply.nextPowerSupply() to iterate on
 * next regulated power supplies.
 *
 * @return YPowerSupply : a pointer to a YPowerSupply object, corresponding to
 *         the first regulated power supply currently online, or a null pointer
 *         if there are none.
 */
function yFirstPowerSupply()
{
    return YPowerSupply::FirstPowerSupply();
}

//--- (end of YPowerSupply functions)
?>