<?php
/*********************************************************************
 *
 *  $Id: yocto_currentloopoutput.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YCurrentLoopOutput, the high-level API for CurrentLoopOutput functions
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

//--- (YCurrentLoopOutput return codes)
//--- (end of YCurrentLoopOutput return codes)
//--- (YCurrentLoopOutput definitions)
if(!defined('Y_LOOPPOWER_NOPWR'))            define('Y_LOOPPOWER_NOPWR',           0);
if(!defined('Y_LOOPPOWER_LOWPWR'))           define('Y_LOOPPOWER_LOWPWR',          1);
if(!defined('Y_LOOPPOWER_POWEROK'))          define('Y_LOOPPOWER_POWEROK',         2);
if(!defined('Y_LOOPPOWER_INVALID'))          define('Y_LOOPPOWER_INVALID',         -1);
if(!defined('Y_CURRENT_INVALID'))            define('Y_CURRENT_INVALID',           YAPI_INVALID_DOUBLE);
if(!defined('Y_CURRENTTRANSITION_INVALID'))  define('Y_CURRENTTRANSITION_INVALID', YAPI_INVALID_STRING);
if(!defined('Y_CURRENTATSTARTUP_INVALID'))   define('Y_CURRENTATSTARTUP_INVALID',  YAPI_INVALID_DOUBLE);
//--- (end of YCurrentLoopOutput definitions)
    #--- (YCurrentLoopOutput yapiwrapper)
   #--- (end of YCurrentLoopOutput yapiwrapper)

//--- (YCurrentLoopOutput declaration)
/**
 * YCurrentLoopOutput Class: CurrentLoopOutput function interface
 *
 * The Yoctopuce application programming interface allows you to change the value of the 4-20mA
 * output as well as to know the current loop state.
 */
class YCurrentLoopOutput extends YFunction
{
    const CURRENT_INVALID                = YAPI_INVALID_DOUBLE;
    const CURRENTTRANSITION_INVALID      = YAPI_INVALID_STRING;
    const CURRENTATSTARTUP_INVALID       = YAPI_INVALID_DOUBLE;
    const LOOPPOWER_NOPWR                = 0;
    const LOOPPOWER_LOWPWR               = 1;
    const LOOPPOWER_POWEROK              = 2;
    const LOOPPOWER_INVALID              = -1;
    //--- (end of YCurrentLoopOutput declaration)

    //--- (YCurrentLoopOutput attributes)
    protected $_current                  = Y_CURRENT_INVALID;            // MeasureVal
    protected $_currentTransition        = Y_CURRENTTRANSITION_INVALID;  // AnyFloatTransition
    protected $_currentAtStartUp         = Y_CURRENTATSTARTUP_INVALID;   // MeasureVal
    protected $_loopPower                = Y_LOOPPOWER_INVALID;          // LoopPwrState
    //--- (end of YCurrentLoopOutput attributes)

    function __construct($str_func)
    {
        //--- (YCurrentLoopOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'CurrentLoopOutput';

        //--- (end of YCurrentLoopOutput constructor)
    }

    //--- (YCurrentLoopOutput implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'current':
            $this->_current = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'currentTransition':
            $this->_currentTransition = $val;
            return 1;
        case 'currentAtStartUp':
            $this->_currentAtStartUp = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'loopPower':
            $this->_loopPower = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current loop, the valid range is from 3 to 21mA. If the loop is
     * not properly powered, the  target current is not reached and
     * loopPower is set to LOWPWR.
     *
     * @param double $newval : a floating point number corresponding to the current loop, the valid range
     * is from 3 to 21mA
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_current($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("current",$rest_val);
    }

    /**
     * Returns the loop current set point in mA.
     *
     * @return double : a floating point number corresponding to the loop current set point in mA
     *
     * On failure, throws an exception or returns Y_CURRENT_INVALID.
     */
    public function get_current()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENT_INVALID;
            }
        }
        $res = $this->_current;
        return $res;
    }

    public function get_currentTransition()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENTTRANSITION_INVALID;
            }
        }
        $res = $this->_currentTransition;
        return $res;
    }

    public function set_currentTransition($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("currentTransition",$rest_val);
    }

    /**
     * Changes the loop current at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param double $newval : a floating point number corresponding to the loop current at device start up
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
     * Returns the current in the loop at device startup, in mA.
     *
     * @return double : a floating point number corresponding to the current in the loop at device startup, in mA
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

    /**
     * Returns the loop powerstate.  POWEROK: the loop
     * is powered. NOPWR: the loop in not powered. LOWPWR: the loop is not
     * powered enough to maintain the current required (insufficient voltage).
     *
     * @return integer : a value among Y_LOOPPOWER_NOPWR, Y_LOOPPOWER_LOWPWR and Y_LOOPPOWER_POWEROK
     * corresponding to the loop powerstate
     *
     * On failure, throws an exception or returns Y_LOOPPOWER_INVALID.
     */
    public function get_loopPower()
    {
        // $res                    is a enumLOOPPWRSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_LOOPPOWER_INVALID;
            }
        }
        $res = $this->_loopPower;
        return $res;
    }

    /**
     * Retrieves a 4-20mA output for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the 4-20mA output is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YCurrentLoopOutput.isOnline() to test if the 4-20mA output is
     * indeed online at a given time. In case of ambiguity when looking for
     * a 4-20mA output by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the 4-20mA output
     *
     * @return YCurrentLoopOutput : a YCurrentLoopOutput object allowing you to drive the 4-20mA output.
     */
    public static function FindCurrentLoopOutput($func)
    {
        // $obj                    is a YCurrentLoopOutput;
        $obj = YFunction::_FindFromCache('CurrentLoopOutput', $func);
        if ($obj == null) {
            $obj = new YCurrentLoopOutput($func);
            YFunction::_AddToCache('CurrentLoopOutput', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of current flowing in the loop. Any current explicit
     * change cancels any ongoing transition process.
     *
     * @param mA_target   : new current value at the end of the transition
     *         (floating-point number, representing the end current in mA)
     * @param integer $ms_duration : total duration of the transition, in milliseconds
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     */
    public function currentMove($mA_target,$ms_duration)
    {
        // $newval                 is a str;
        if ($mA_target < 3.0) {
            $mA_target  = 3.0;
        }
        if ($mA_target > 21.0) {
            $mA_target = 21.0;
        }
        $newval = sprintf('%d:%d', round($mA_target*65536), $ms_duration);

        return $this->set_currentTransition($newval);
    }

    public function setCurrent($newval)
    { return $this->set_current($newval); }

    public function current()
    { return $this->get_current(); }

    public function currentTransition()
    { return $this->get_currentTransition(); }

    public function setCurrentTransition($newval)
    { return $this->set_currentTransition($newval); }

    public function setCurrentAtStartUp($newval)
    { return $this->set_currentAtStartUp($newval); }

    public function currentAtStartUp()
    { return $this->get_currentAtStartUp(); }

    public function loopPower()
    { return $this->get_loopPower(); }

    /**
     * Continues the enumeration of 4-20mA outputs started using yFirstCurrentLoopOutput().
     * Caution: You can't make any assumption about the returned 4-20mA outputs order.
     * If you want to find a specific a 4-20mA output, use CurrentLoopOutput.findCurrentLoopOutput()
     * and a hardwareID or a logical name.
     *
     * @return YCurrentLoopOutput : a pointer to a YCurrentLoopOutput object, corresponding to
     *         a 4-20mA output currently online, or a null pointer
     *         if there are no more 4-20mA outputs to enumerate.
     */
    public function nextCurrentLoopOutput()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindCurrentLoopOutput($next_hwid);
    }

    /**
     * Starts the enumeration of 4-20mA outputs currently accessible.
     * Use the method YCurrentLoopOutput.nextCurrentLoopOutput() to iterate on
     * next 4-20mA outputs.
     *
     * @return YCurrentLoopOutput : a pointer to a YCurrentLoopOutput object, corresponding to
     *         the first 4-20mA output currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCurrentLoopOutput()
    {   $next_hwid = YAPI::getFirstHardwareId('CurrentLoopOutput');
        if($next_hwid == null) return null;
        return self::FindCurrentLoopOutput($next_hwid);
    }

    //--- (end of YCurrentLoopOutput implementation)

};

//--- (YCurrentLoopOutput functions)

/**
 * Retrieves a 4-20mA output for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the 4-20mA output is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YCurrentLoopOutput.isOnline() to test if the 4-20mA output is
 * indeed online at a given time. In case of ambiguity when looking for
 * a 4-20mA output by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the 4-20mA output
 *
 * @return YCurrentLoopOutput : a YCurrentLoopOutput object allowing you to drive the 4-20mA output.
 */
function yFindCurrentLoopOutput($func)
{
    return YCurrentLoopOutput::FindCurrentLoopOutput($func);
}

/**
 * Starts the enumeration of 4-20mA outputs currently accessible.
 * Use the method YCurrentLoopOutput.nextCurrentLoopOutput() to iterate on
 * next 4-20mA outputs.
 *
 * @return YCurrentLoopOutput : a pointer to a YCurrentLoopOutput object, corresponding to
 *         the first 4-20mA output currently online, or a null pointer
 *         if there are none.
 */
function yFirstCurrentLoopOutput()
{
    return YCurrentLoopOutput::FirstCurrentLoopOutput();
}

//--- (end of YCurrentLoopOutput functions)
?>