<?php
/*********************************************************************
 *
 *  $Id: yocto_pwmoutput.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YPwmOutput, the high-level API for PwmOutput functions
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

//--- (YPwmOutput return codes)
//--- (end of YPwmOutput return codes)
//--- (YPwmOutput definitions)
if(!defined('Y_ENABLED_FALSE'))              define('Y_ENABLED_FALSE',             0);
if(!defined('Y_ENABLED_TRUE'))               define('Y_ENABLED_TRUE',              1);
if(!defined('Y_ENABLED_INVALID'))            define('Y_ENABLED_INVALID',           -1);
if(!defined('Y_ENABLEDATPOWERON_FALSE'))     define('Y_ENABLEDATPOWERON_FALSE',    0);
if(!defined('Y_ENABLEDATPOWERON_TRUE'))      define('Y_ENABLEDATPOWERON_TRUE',     1);
if(!defined('Y_ENABLEDATPOWERON_INVALID'))   define('Y_ENABLEDATPOWERON_INVALID',  -1);
if(!defined('Y_FREQUENCY_INVALID'))          define('Y_FREQUENCY_INVALID',         YAPI_INVALID_DOUBLE);
if(!defined('Y_PERIOD_INVALID'))             define('Y_PERIOD_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_DUTYCYCLE_INVALID'))          define('Y_DUTYCYCLE_INVALID',         YAPI_INVALID_DOUBLE);
if(!defined('Y_PULSEDURATION_INVALID'))      define('Y_PULSEDURATION_INVALID',     YAPI_INVALID_DOUBLE);
if(!defined('Y_PWMTRANSITION_INVALID'))      define('Y_PWMTRANSITION_INVALID',     YAPI_INVALID_STRING);
if(!defined('Y_DUTYCYCLEATPOWERON_INVALID')) define('Y_DUTYCYCLEATPOWERON_INVALID', YAPI_INVALID_DOUBLE);
//--- (end of YPwmOutput definitions)
    #--- (YPwmOutput yapiwrapper)
   #--- (end of YPwmOutput yapiwrapper)

//--- (YPwmOutput declaration)
/**
 * YPwmOutput Class: PwmOutput function interface
 *
 * The Yoctopuce application programming interface allows you to configure, start, and stop the PWM.
 */
class YPwmOutput extends YFunction
{
    const ENABLED_FALSE                  = 0;
    const ENABLED_TRUE                   = 1;
    const ENABLED_INVALID                = -1;
    const FREQUENCY_INVALID              = YAPI_INVALID_DOUBLE;
    const PERIOD_INVALID                 = YAPI_INVALID_DOUBLE;
    const DUTYCYCLE_INVALID              = YAPI_INVALID_DOUBLE;
    const PULSEDURATION_INVALID          = YAPI_INVALID_DOUBLE;
    const PWMTRANSITION_INVALID          = YAPI_INVALID_STRING;
    const ENABLEDATPOWERON_FALSE         = 0;
    const ENABLEDATPOWERON_TRUE          = 1;
    const ENABLEDATPOWERON_INVALID       = -1;
    const DUTYCYCLEATPOWERON_INVALID     = YAPI_INVALID_DOUBLE;
    //--- (end of YPwmOutput declaration)

    //--- (YPwmOutput attributes)
    protected $_enabled                  = Y_ENABLED_INVALID;            // Bool
    protected $_frequency                = Y_FREQUENCY_INVALID;          // MeasureVal
    protected $_period                   = Y_PERIOD_INVALID;             // MeasureVal
    protected $_dutyCycle                = Y_DUTYCYCLE_INVALID;          // MeasureVal
    protected $_pulseDuration            = Y_PULSEDURATION_INVALID;      // MeasureVal
    protected $_pwmTransition            = Y_PWMTRANSITION_INVALID;      // Text
    protected $_enabledAtPowerOn         = Y_ENABLEDATPOWERON_INVALID;   // Bool
    protected $_dutyCycleAtPowerOn       = Y_DUTYCYCLEATPOWERON_INVALID; // MeasureVal
    //--- (end of YPwmOutput attributes)

    function __construct($str_func)
    {
        //--- (YPwmOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'PwmOutput';

        //--- (end of YPwmOutput constructor)
    }

    //--- (YPwmOutput implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'frequency':
            $this->_frequency = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'period':
            $this->_period = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'dutyCycle':
            $this->_dutyCycle = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'pulseDuration':
            $this->_pulseDuration = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'pwmTransition':
            $this->_pwmTransition = $val;
            return 1;
        case 'enabledAtPowerOn':
            $this->_enabledAtPowerOn = intval($val);
            return 1;
        case 'dutyCycleAtPowerOn':
            $this->_dutyCycleAtPowerOn = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the state of the PWMs.
     *
     * @return integer : either Y_ENABLED_FALSE or Y_ENABLED_TRUE, according to the state of the PWMs
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
     * Stops or starts the PWM.
     *
     * @param integer $newval : either Y_ENABLED_FALSE or Y_ENABLED_TRUE
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
     * Changes the PWM frequency. The duty cycle is kept unchanged thanks to an
     * automatic pulse width change, in other words, the change will not be applied
     * before the end of the current period. This can significantly affect reaction
     * time at low frequencies.
     * To stop the PWM signal, do not set the frequency to zero, use the set_enabled()
     * method instead.
     *
     * @param double $newval : a floating point number corresponding to the PWM frequency
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_frequency($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("frequency",$rest_val);
    }

    /**
     * Returns the PWM frequency in Hz.
     *
     * @return double : a floating point number corresponding to the PWM frequency in Hz
     *
     * On failure, throws an exception or returns Y_FREQUENCY_INVALID.
     */
    public function get_frequency()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_FREQUENCY_INVALID;
            }
        }
        $res = $this->_frequency;
        return $res;
    }

    /**
     * Changes the PWM period in milliseconds. Caution: in order to avoid  random truncation of
     * the current pulse, the change will not be applied
     * before the end of the current period. This can significantly affect reaction
     * time at low frequencies.
     *
     * @param double $newval : a floating point number corresponding to the PWM period in milliseconds
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_period($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("period",$rest_val);
    }

    /**
     * Returns the PWM period in milliseconds.
     *
     * @return double : a floating point number corresponding to the PWM period in milliseconds
     *
     * On failure, throws an exception or returns Y_PERIOD_INVALID.
     */
    public function get_period()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PERIOD_INVALID;
            }
        }
        $res = $this->_period;
        return $res;
    }

    /**
     * Changes the PWM duty cycle, in per cents.
     *
     * @param double $newval : a floating point number corresponding to the PWM duty cycle, in per cents
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_dutyCycle($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("dutyCycle",$rest_val);
    }

    /**
     * Returns the PWM duty cycle, in per cents.
     *
     * @return double : a floating point number corresponding to the PWM duty cycle, in per cents
     *
     * On failure, throws an exception or returns Y_DUTYCYCLE_INVALID.
     */
    public function get_dutyCycle()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DUTYCYCLE_INVALID;
            }
        }
        $res = $this->_dutyCycle;
        return $res;
    }

    /**
     * Changes the PWM pulse length, in milliseconds. A pulse length cannot be longer than period,
     * otherwise it is truncated.
     *
     * @param double $newval : a floating point number corresponding to the PWM pulse length, in milliseconds
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_pulseDuration($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("pulseDuration",$rest_val);
    }

    /**
     * Returns the PWM pulse length in milliseconds, as a floating point number.
     *
     * @return double : a floating point number corresponding to the PWM pulse length in milliseconds, as
     * a floating point number
     *
     * On failure, throws an exception or returns Y_PULSEDURATION_INVALID.
     */
    public function get_pulseDuration()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PULSEDURATION_INVALID;
            }
        }
        $res = $this->_pulseDuration;
        return $res;
    }

    public function get_pwmTransition()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PWMTRANSITION_INVALID;
            }
        }
        $res = $this->_pwmTransition;
        return $res;
    }

    public function set_pwmTransition($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("pwmTransition",$rest_val);
    }

    /**
     * Returns the state of the PWM at device power on.
     *
     * @return integer : either Y_ENABLEDATPOWERON_FALSE or Y_ENABLEDATPOWERON_TRUE, according to the
     * state of the PWM at device power on
     *
     * On failure, throws an exception or returns Y_ENABLEDATPOWERON_INVALID.
     */
    public function get_enabledAtPowerOn()
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ENABLEDATPOWERON_INVALID;
            }
        }
        $res = $this->_enabledAtPowerOn;
        return $res;
    }

    /**
     * Changes the state of the PWM at device power on. Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     *
     * @param integer $newval : either Y_ENABLEDATPOWERON_FALSE or Y_ENABLEDATPOWERON_TRUE, according to
     * the state of the PWM at device power on
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_enabledAtPowerOn($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabledAtPowerOn",$rest_val);
    }

    /**
     * Changes the PWM duty cycle at device power on. Remember to call the matching
     * module saveToFlash() method, otherwise this call will have no effect.
     *
     * @param double $newval : a floating point number corresponding to the PWM duty cycle at device power on
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_dutyCycleAtPowerOn($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("dutyCycleAtPowerOn",$rest_val);
    }

    /**
     * Returns the PWMs duty cycle at device power on as a floating point number between 0 and 100.
     *
     * @return double : a floating point number corresponding to the PWMs duty cycle at device power on as
     * a floating point number between 0 and 100
     *
     * On failure, throws an exception or returns Y_DUTYCYCLEATPOWERON_INVALID.
     */
    public function get_dutyCycleAtPowerOn()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DUTYCYCLEATPOWERON_INVALID;
            }
        }
        $res = $this->_dutyCycleAtPowerOn;
        return $res;
    }

    /**
     * Retrieves a PWM for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the PWM is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YPwmOutput.isOnline() to test if the PWM is
     * indeed online at a given time. In case of ambiguity when looking for
     * a PWM by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the PWM
     *
     * @return YPwmOutput : a YPwmOutput object allowing you to drive the PWM.
     */
    public static function FindPwmOutput($func)
    {
        // $obj                    is a YPwmOutput;
        $obj = YFunction::_FindFromCache('PwmOutput', $func);
        if ($obj == null) {
            $obj = new YPwmOutput($func);
            YFunction::_AddToCache('PwmOutput', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of the pulse duration toward a given value.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param ms_target   : new pulse duration at the end of the transition
     *         (floating-point number, representing the pulse duration in milliseconds)
     * @param integer $ms_duration : total duration of the transition, in milliseconds
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function pulseDurationMove($ms_target,$ms_duration)
    {
        // $newval                 is a str;
        if ($ms_target < 0.0) {
            $ms_target = 0.0;
        }
        $newval = sprintf('%dms:%d', round($ms_target*65536), $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Performs a smooth change of the duty cycle toward a given value.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param target      : new duty cycle at the end of the transition
     *         (percentage, floating-point number between 0 and 100)
     * @param integer $ms_duration : total duration of the transition, in milliseconds
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function dutyCycleMove($target,$ms_duration)
    {
        // $newval                 is a str;
        if ($target < 0.0) {
            $target = 0.0;
        }
        if ($target > 100.0) {
            $target = 100.0;
        }
        $newval = sprintf('%d:%d', round($target*65536), $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Performs a smooth frequency change toward a given value.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param target      : new frequency at the end of the transition (floating-point number)
     * @param integer $ms_duration : total duration of the transition, in milliseconds
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function frequencyMove($target,$ms_duration)
    {
        // $newval                 is a str;
        if ($target < 0.001) {
            $target = 0.001;
        }
        $newval = sprintf('%FHz:%d', $target, $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Performs a smooth transition toward a specified value of the phase shift between this channel
     * and the other channel. The phase shift is executed by slightly changing the frequency
     * temporarily during the specified duration. This function only makes sense when both channels
     * are running, either at the same frequency, or at a multiple of the channel frequency.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param target      : phase shift at the end of the transition, in milliseconds (floating-point number)
     * @param integer $ms_duration : total duration of the transition, in milliseconds
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function phaseMove($target,$ms_duration)
    {
        // $newval                 is a str;
        $newval = sprintf('%Fps:%d', $target, $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Trigger a given number of pulses of specified duration, at current frequency.
     * At the end of the pulse train, revert to the original state of the PWM generator.
     *
     * @param double $ms_target : desired pulse duration
     *         (floating-point number, representing the pulse duration in milliseconds)
     * @param n_pulses  : desired pulse count
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerPulsesByDuration($ms_target,$n_pulses)
    {
        // $newval                 is a str;
        if ($ms_target < 0.0) {
            $ms_target = 0.0;
        }
        $newval = sprintf('%dms*%d', round($ms_target*65536), $n_pulses);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Trigger a given number of pulses of specified duration, at current frequency.
     * At the end of the pulse train, revert to the original state of the PWM generator.
     *
     * @param target   : desired duty cycle for the generated pulses
     *         (percentage, floating-point number between 0 and 100)
     * @param integer $n_pulses : desired pulse count
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerPulsesByDutyCycle($target,$n_pulses)
    {
        // $newval                 is a str;
        if ($target < 0.0) {
            $target = 0.0;
        }
        if ($target > 100.0) {
            $target = 100.0;
        }
        $newval = sprintf('%d*%d', round($target*65536), $n_pulses);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Trigger a given number of pulses at the specified frequency, using current duty cycle.
     * At the end of the pulse train, revert to the original state of the PWM generator.
     *
     * @param target   : desired frequency for the generated pulses (floating-point number)
     * @param integer $n_pulses : desired pulse count
     *
     * @return integer : YAPI_SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerPulsesByFrequency($target,$n_pulses)
    {
        // $newval                 is a str;
        if ($target < 0.001) {
            $target = 0.001;
        }
        $newval = sprintf('%FHz*%d', $target, $n_pulses);
        return $this->set_pwmTransition($newval);
    }

    public function markForRepeat()
    {
        return $this->set_pwmTransition(':');
    }

    public function repeatFromMark()
    {
        return $this->set_pwmTransition('R');
    }

    public function enabled()
    { return $this->get_enabled(); }

    public function setEnabled($newval)
    { return $this->set_enabled($newval); }

    public function setFrequency($newval)
    { return $this->set_frequency($newval); }

    public function frequency()
    { return $this->get_frequency(); }

    public function setPeriod($newval)
    { return $this->set_period($newval); }

    public function period()
    { return $this->get_period(); }

    public function setDutyCycle($newval)
    { return $this->set_dutyCycle($newval); }

    public function dutyCycle()
    { return $this->get_dutyCycle(); }

    public function setPulseDuration($newval)
    { return $this->set_pulseDuration($newval); }

    public function pulseDuration()
    { return $this->get_pulseDuration(); }

    public function pwmTransition()
    { return $this->get_pwmTransition(); }

    public function setPwmTransition($newval)
    { return $this->set_pwmTransition($newval); }

    public function enabledAtPowerOn()
    { return $this->get_enabledAtPowerOn(); }

    public function setEnabledAtPowerOn($newval)
    { return $this->set_enabledAtPowerOn($newval); }

    public function setDutyCycleAtPowerOn($newval)
    { return $this->set_dutyCycleAtPowerOn($newval); }

    public function dutyCycleAtPowerOn()
    { return $this->get_dutyCycleAtPowerOn(); }

    /**
     * Continues the enumeration of PWMs started using yFirstPwmOutput().
     * Caution: You can't make any assumption about the returned PWMs order.
     * If you want to find a specific a PWM, use PwmOutput.findPwmOutput()
     * and a hardwareID or a logical name.
     *
     * @return YPwmOutput : a pointer to a YPwmOutput object, corresponding to
     *         a PWM currently online, or a null pointer
     *         if there are no more PWMs to enumerate.
     */
    public function nextPwmOutput()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindPwmOutput($next_hwid);
    }

    /**
     * Starts the enumeration of PWMs currently accessible.
     * Use the method YPwmOutput.nextPwmOutput() to iterate on
     * next PWMs.
     *
     * @return YPwmOutput : a pointer to a YPwmOutput object, corresponding to
     *         the first PWM currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPwmOutput()
    {   $next_hwid = YAPI::getFirstHardwareId('PwmOutput');
        if($next_hwid == null) return null;
        return self::FindPwmOutput($next_hwid);
    }

    //--- (end of YPwmOutput implementation)

};

//--- (YPwmOutput functions)

/**
 * Retrieves a PWM for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the PWM is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YPwmOutput.isOnline() to test if the PWM is
 * indeed online at a given time. In case of ambiguity when looking for
 * a PWM by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the PWM
 *
 * @return YPwmOutput : a YPwmOutput object allowing you to drive the PWM.
 */
function yFindPwmOutput($func)
{
    return YPwmOutput::FindPwmOutput($func);
}

/**
 * Starts the enumeration of PWMs currently accessible.
 * Use the method YPwmOutput.nextPwmOutput() to iterate on
 * next PWMs.
 *
 * @return YPwmOutput : a pointer to a YPwmOutput object, corresponding to
 *         the first PWM currently online, or a null pointer
 *         if there are none.
 */
function yFirstPwmOutput()
{
    return YPwmOutput::FirstPwmOutput();
}

//--- (end of YPwmOutput functions)
?>