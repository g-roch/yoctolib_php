<?php
/*********************************************************************
 *
 *  $Id: yocto_voltageoutput.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YVoltageOutput, the high-level API for VoltageOutput functions
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

//--- (YVoltageOutput return codes)
//--- (end of YVoltageOutput return codes)
//--- (YVoltageOutput definitions)
if(!defined('Y_CURRENTVOLTAGE_INVALID'))     define('Y_CURRENTVOLTAGE_INVALID',    YAPI_INVALID_DOUBLE);
if(!defined('Y_VOLTAGETRANSITION_INVALID'))  define('Y_VOLTAGETRANSITION_INVALID', YAPI_INVALID_STRING);
if(!defined('Y_VOLTAGEATSTARTUP_INVALID'))   define('Y_VOLTAGEATSTARTUP_INVALID',  YAPI_INVALID_DOUBLE);
//--- (end of YVoltageOutput definitions)
    #--- (YVoltageOutput yapiwrapper)
   #--- (end of YVoltageOutput yapiwrapper)

//--- (YVoltageOutput declaration)
/**
 * YVoltageOutput Class: VoltageOutput function interface
 *
 * The Yoctopuce application programming interface allows you to change the value of the voltage output.
 */
class YVoltageOutput extends YFunction
{
    const CURRENTVOLTAGE_INVALID         = YAPI_INVALID_DOUBLE;
    const VOLTAGETRANSITION_INVALID      = YAPI_INVALID_STRING;
    const VOLTAGEATSTARTUP_INVALID       = YAPI_INVALID_DOUBLE;
    //--- (end of YVoltageOutput declaration)

    //--- (YVoltageOutput attributes)
    protected $_currentVoltage           = Y_CURRENTVOLTAGE_INVALID;     // MeasureVal
    protected $_voltageTransition        = Y_VOLTAGETRANSITION_INVALID;  // AnyFloatTransition
    protected $_voltageAtStartUp         = Y_VOLTAGEATSTARTUP_INVALID;   // MeasureVal
    //--- (end of YVoltageOutput attributes)

    function __construct($str_func)
    {
        //--- (YVoltageOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'VoltageOutput';

        //--- (end of YVoltageOutput constructor)
    }

    //--- (YVoltageOutput implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'currentVoltage':
            $this->_currentVoltage = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'voltageTransition':
            $this->_voltageTransition = $val;
            return 1;
        case 'voltageAtStartUp':
            $this->_voltageAtStartUp = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the output voltage, in V. Valid range is from 0 to 10V.
     *
     * @param double $newval : a floating point number corresponding to the output voltage, in V
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentVoltage($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentVoltage",$rest_val);
    }

    /**
     * Returns the output voltage set point, in V.
     *
     * @return double : a floating point number corresponding to the output voltage set point, in V
     *
     * On failure, throws an exception or returns Y_CURRENTVOLTAGE_INVALID.
     */
    public function get_currentVoltage()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENTVOLTAGE_INVALID;
            }
        }
        $res = $this->_currentVoltage;
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
     * Changes the output voltage at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param double $newval : a floating point number corresponding to the output voltage at device start up
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
     * Returns the selected voltage output at device startup, in V.
     *
     * @return double : a floating point number corresponding to the selected voltage output at device startup, in V
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
     * Retrieves a voltage output for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the voltage output is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YVoltageOutput.isOnline() to test if the voltage output is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage output by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the voltage output
     *
     * @return YVoltageOutput : a YVoltageOutput object allowing you to drive the voltage output.
     */
    public static function FindVoltageOutput($func)
    {
        // $obj                    is a YVoltageOutput;
        $obj = YFunction::_FindFromCache('VoltageOutput', $func);
        if ($obj == null) {
            $obj = new YVoltageOutput($func);
            YFunction::_AddToCache('VoltageOutput', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of output voltage. Any explicit voltage
     * change cancels any ongoing transition process.
     *
     * @param V_target   : new output voltage value at the end of the transition
     *         (floating-point number, representing the end voltage in V)
     * @param integer $ms_duration : total duration of the transition, in milliseconds
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     */
    public function voltageMove($V_target,$ms_duration)
    {
        // $newval                 is a str;
        if ($V_target < 0.0) {
            $V_target  = 0.0;
        }
        if ($V_target > 10.0) {
            $V_target = 10.0;
        }
        $newval = sprintf('%d:%d', round($V_target*65536), $ms_duration);

        return $this->set_voltageTransition($newval);
    }

    public function setCurrentVoltage($newval)
    { return $this->set_currentVoltage($newval); }

    public function currentVoltage()
    { return $this->get_currentVoltage(); }

    public function voltageTransition()
    { return $this->get_voltageTransition(); }

    public function setVoltageTransition($newval)
    { return $this->set_voltageTransition($newval); }

    public function setVoltageAtStartUp($newval)
    { return $this->set_voltageAtStartUp($newval); }

    public function voltageAtStartUp()
    { return $this->get_voltageAtStartUp(); }

    /**
     * Continues the enumeration of voltage outputs started using yFirstVoltageOutput().
     * Caution: You can't make any assumption about the returned voltage outputs order.
     * If you want to find a specific a voltage output, use VoltageOutput.findVoltageOutput()
     * and a hardwareID or a logical name.
     *
     * @return YVoltageOutput : a pointer to a YVoltageOutput object, corresponding to
     *         a voltage output currently online, or a null pointer
     *         if there are no more voltage outputs to enumerate.
     */
    public function nextVoltageOutput()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindVoltageOutput($next_hwid);
    }

    /**
     * Starts the enumeration of voltage outputs currently accessible.
     * Use the method YVoltageOutput.nextVoltageOutput() to iterate on
     * next voltage outputs.
     *
     * @return YVoltageOutput : a pointer to a YVoltageOutput object, corresponding to
     *         the first voltage output currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVoltageOutput()
    {   $next_hwid = YAPI::getFirstHardwareId('VoltageOutput');
        if($next_hwid == null) return null;
        return self::FindVoltageOutput($next_hwid);
    }

    //--- (end of YVoltageOutput implementation)

};

//--- (YVoltageOutput functions)

/**
 * Retrieves a voltage output for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the voltage output is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YVoltageOutput.isOnline() to test if the voltage output is
 * indeed online at a given time. In case of ambiguity when looking for
 * a voltage output by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the voltage output
 *
 * @return YVoltageOutput : a YVoltageOutput object allowing you to drive the voltage output.
 */
function yFindVoltageOutput($func)
{
    return YVoltageOutput::FindVoltageOutput($func);
}

/**
 * Starts the enumeration of voltage outputs currently accessible.
 * Use the method YVoltageOutput.nextVoltageOutput() to iterate on
 * next voltage outputs.
 *
 * @return YVoltageOutput : a pointer to a YVoltageOutput object, corresponding to
 *         the first voltage output currently online, or a null pointer
 *         if there are none.
 */
function yFirstVoltageOutput()
{
    return YVoltageOutput::FirstVoltageOutput();
}

//--- (end of YVoltageOutput functions)
?>