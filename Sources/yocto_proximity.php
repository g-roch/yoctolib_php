<?php
/*********************************************************************
 *
 *  $Id: yocto_proximity.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YProximity, the high-level API for Proximity functions
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

//--- (YProximity return codes)
//--- (end of YProximity return codes)
//--- (YProximity definitions)
if(!defined('Y_ISPRESENT_FALSE'))            define('Y_ISPRESENT_FALSE',           0);
if(!defined('Y_ISPRESENT_TRUE'))             define('Y_ISPRESENT_TRUE',            1);
if(!defined('Y_ISPRESENT_INVALID'))          define('Y_ISPRESENT_INVALID',         -1);
if(!defined('Y_PROXIMITYREPORTMODE_NUMERIC')) define('Y_PROXIMITYREPORTMODE_NUMERIC', 0);
if(!defined('Y_PROXIMITYREPORTMODE_PRESENCE')) define('Y_PROXIMITYREPORTMODE_PRESENCE', 1);
if(!defined('Y_PROXIMITYREPORTMODE_PULSECOUNT')) define('Y_PROXIMITYREPORTMODE_PULSECOUNT', 2);
if(!defined('Y_PROXIMITYREPORTMODE_INVALID')) define('Y_PROXIMITYREPORTMODE_INVALID', -1);
if(!defined('Y_SIGNALVALUE_INVALID'))        define('Y_SIGNALVALUE_INVALID',       YAPI_INVALID_DOUBLE);
if(!defined('Y_DETECTIONTHRESHOLD_INVALID')) define('Y_DETECTIONTHRESHOLD_INVALID', YAPI_INVALID_UINT);
if(!defined('Y_DETECTIONHYSTERESIS_INVALID')) define('Y_DETECTIONHYSTERESIS_INVALID', YAPI_INVALID_UINT);
if(!defined('Y_PRESENCEMINTIME_INVALID'))    define('Y_PRESENCEMINTIME_INVALID',   YAPI_INVALID_UINT);
if(!defined('Y_REMOVALMINTIME_INVALID'))     define('Y_REMOVALMINTIME_INVALID',    YAPI_INVALID_UINT);
if(!defined('Y_LASTTIMEAPPROACHED_INVALID')) define('Y_LASTTIMEAPPROACHED_INVALID', YAPI_INVALID_LONG);
if(!defined('Y_LASTTIMEREMOVED_INVALID'))    define('Y_LASTTIMEREMOVED_INVALID',   YAPI_INVALID_LONG);
if(!defined('Y_PULSECOUNTER_INVALID'))       define('Y_PULSECOUNTER_INVALID',      YAPI_INVALID_LONG);
if(!defined('Y_PULSETIMER_INVALID'))         define('Y_PULSETIMER_INVALID',        YAPI_INVALID_LONG);
//--- (end of YProximity definitions)
    #--- (YProximity yapiwrapper)
   #--- (end of YProximity yapiwrapper)

//--- (YProximity declaration)
/**
 * YProximity Class: Proximity function interface
 *
 * The Yoctopuce class YProximity allows you to use and configure Yoctopuce proximity
 * sensors. It inherits from the YSensor class the core functions to read measurements,
 * to register callback functions, to access the autonomous datalogger.
 * This class adds the ability to easily perform a one-point linear calibration
 * to compensate the effect of a glass or filter placed in front of the sensor.
 */
class YProximity extends YSensor
{
    const SIGNALVALUE_INVALID            = YAPI_INVALID_DOUBLE;
    const DETECTIONTHRESHOLD_INVALID     = YAPI_INVALID_UINT;
    const DETECTIONHYSTERESIS_INVALID    = YAPI_INVALID_UINT;
    const PRESENCEMINTIME_INVALID        = YAPI_INVALID_UINT;
    const REMOVALMINTIME_INVALID         = YAPI_INVALID_UINT;
    const ISPRESENT_FALSE                = 0;
    const ISPRESENT_TRUE                 = 1;
    const ISPRESENT_INVALID              = -1;
    const LASTTIMEAPPROACHED_INVALID     = YAPI_INVALID_LONG;
    const LASTTIMEREMOVED_INVALID        = YAPI_INVALID_LONG;
    const PULSECOUNTER_INVALID           = YAPI_INVALID_LONG;
    const PULSETIMER_INVALID             = YAPI_INVALID_LONG;
    const PROXIMITYREPORTMODE_NUMERIC    = 0;
    const PROXIMITYREPORTMODE_PRESENCE   = 1;
    const PROXIMITYREPORTMODE_PULSECOUNT = 2;
    const PROXIMITYREPORTMODE_INVALID    = -1;
    //--- (end of YProximity declaration)

    //--- (YProximity attributes)
    protected $_signalValue              = Y_SIGNALVALUE_INVALID;        // MeasureVal
    protected $_detectionThreshold       = Y_DETECTIONTHRESHOLD_INVALID; // UInt31
    protected $_detectionHysteresis      = Y_DETECTIONHYSTERESIS_INVALID; // UInt31
    protected $_presenceMinTime          = Y_PRESENCEMINTIME_INVALID;    // UInt31
    protected $_removalMinTime           = Y_REMOVALMINTIME_INVALID;     // UInt31
    protected $_isPresent                = Y_ISPRESENT_INVALID;          // Bool
    protected $_lastTimeApproached       = Y_LASTTIMEAPPROACHED_INVALID; // Time
    protected $_lastTimeRemoved          = Y_LASTTIMEREMOVED_INVALID;    // Time
    protected $_pulseCounter             = Y_PULSECOUNTER_INVALID;       // UInt
    protected $_pulseTimer               = Y_PULSETIMER_INVALID;         // Time
    protected $_proximityReportMode      = Y_PROXIMITYREPORTMODE_INVALID; // ProximityReportModeType
    //--- (end of YProximity attributes)

    function __construct($str_func)
    {
        //--- (YProximity constructor)
        parent::__construct($str_func);
        $this->_className = 'Proximity';

        //--- (end of YProximity constructor)
    }

    //--- (YProximity implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'signalValue':
            $this->_signalValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'detectionThreshold':
            $this->_detectionThreshold = intval($val);
            return 1;
        case 'detectionHysteresis':
            $this->_detectionHysteresis = intval($val);
            return 1;
        case 'presenceMinTime':
            $this->_presenceMinTime = intval($val);
            return 1;
        case 'removalMinTime':
            $this->_removalMinTime = intval($val);
            return 1;
        case 'isPresent':
            $this->_isPresent = intval($val);
            return 1;
        case 'lastTimeApproached':
            $this->_lastTimeApproached = intval($val);
            return 1;
        case 'lastTimeRemoved':
            $this->_lastTimeRemoved = intval($val);
            return 1;
        case 'pulseCounter':
            $this->_pulseCounter = intval($val);
            return 1;
        case 'pulseTimer':
            $this->_pulseTimer = intval($val);
            return 1;
        case 'proximityReportMode':
            $this->_proximityReportMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current value of signal measured by the proximity sensor.
     *
     * @return double : a floating point number corresponding to the current value of signal measured by
     * the proximity sensor
     *
     * On failure, throws an exception or returns Y_SIGNALVALUE_INVALID.
     */
    public function get_signalValue()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_SIGNALVALUE_INVALID;
            }
        }
        $res = round($this->_signalValue * 1000) / 1000;
        return $res;
    }

    /**
     * Returns the threshold used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     *
     * @return integer : an integer corresponding to the threshold used to determine the logical state of
     * the proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * On failure, throws an exception or returns Y_DETECTIONTHRESHOLD_INVALID.
     */
    public function get_detectionThreshold()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DETECTIONTHRESHOLD_INVALID;
            }
        }
        $res = $this->_detectionThreshold;
        return $res;
    }

    /**
     * Changes the threshold used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     *
     * @param integer $newval : an integer corresponding to the threshold used to determine the logical
     * state of the proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_detectionThreshold($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("detectionThreshold",$rest_val);
    }

    /**
     * Returns the hysteresis used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     *
     * @return integer : an integer corresponding to the hysteresis used to determine the logical state of
     * the proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * On failure, throws an exception or returns Y_DETECTIONHYSTERESIS_INVALID.
     */
    public function get_detectionHysteresis()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DETECTIONHYSTERESIS_INVALID;
            }
        }
        $res = $this->_detectionHysteresis;
        return $res;
    }

    /**
     * Changes the hysteresis used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     *
     * @param integer $newval : an integer corresponding to the hysteresis used to determine the logical
     * state of the proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_detectionHysteresis($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("detectionHysteresis",$rest_val);
    }

    /**
     * Returns the minimal detection duration before signalling a presence event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     *
     * @return integer : an integer corresponding to the minimal detection duration before signalling a presence event
     *
     * On failure, throws an exception or returns Y_PRESENCEMINTIME_INVALID.
     */
    public function get_presenceMinTime()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PRESENCEMINTIME_INVALID;
            }
        }
        $res = $this->_presenceMinTime;
        return $res;
    }

    /**
     * Changes the minimal detection duration before signalling a presence event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     *
     * @param integer $newval : an integer corresponding to the minimal detection duration before
     * signalling a presence event
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_presenceMinTime($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("presenceMinTime",$rest_val);
    }

    /**
     * Returns the minimal detection duration before signalling a removal event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     *
     * @return integer : an integer corresponding to the minimal detection duration before signalling a removal event
     *
     * On failure, throws an exception or returns Y_REMOVALMINTIME_INVALID.
     */
    public function get_removalMinTime()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_REMOVALMINTIME_INVALID;
            }
        }
        $res = $this->_removalMinTime;
        return $res;
    }

    /**
     * Changes the minimal detection duration before signalling a removal event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     *
     * @param integer $newval : an integer corresponding to the minimal detection duration before
     * signalling a removal event
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_removalMinTime($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("removalMinTime",$rest_val);
    }

    /**
     * Returns true if the input (considered as binary) is active (detection value is smaller than the
     * specified threshold), and false otherwise.
     *
     * @return integer : either Y_ISPRESENT_FALSE or Y_ISPRESENT_TRUE, according to true if the input
     * (considered as binary) is active (detection value is smaller than the specified threshold), and false otherwise
     *
     * On failure, throws an exception or returns Y_ISPRESENT_INVALID.
     */
    public function get_isPresent()
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ISPRESENT_INVALID;
            }
        }
        $res = $this->_isPresent;
        return $res;
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last observed
     * detection (the input contact transitioned from absent to present).
     *
     * @return integer : an integer corresponding to the number of elapsed milliseconds between the module
     * power on and the last observed
     *         detection (the input contact transitioned from absent to present)
     *
     * On failure, throws an exception or returns Y_LASTTIMEAPPROACHED_INVALID.
     */
    public function get_lastTimeApproached()
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_LASTTIMEAPPROACHED_INVALID;
            }
        }
        $res = $this->_lastTimeApproached;
        return $res;
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last observed
     * detection (the input contact transitioned from present to absent).
     *
     * @return integer : an integer corresponding to the number of elapsed milliseconds between the module
     * power on and the last observed
     *         detection (the input contact transitioned from present to absent)
     *
     * On failure, throws an exception or returns Y_LASTTIMEREMOVED_INVALID.
     */
    public function get_lastTimeRemoved()
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_LASTTIMEREMOVED_INVALID;
            }
        }
        $res = $this->_lastTimeRemoved;
        return $res;
    }

    /**
     * Returns the pulse counter value. The value is a 32 bit integer. In case
     * of overflow (>=2^32), the counter will wrap. To reset the counter, just
     * call the resetCounter() method.
     *
     * @return integer : an integer corresponding to the pulse counter value
     *
     * On failure, throws an exception or returns Y_PULSECOUNTER_INVALID.
     */
    public function get_pulseCounter()
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PULSECOUNTER_INVALID;
            }
        }
        $res = $this->_pulseCounter;
        return $res;
    }

    public function set_pulseCounter($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseCounter",$rest_val);
    }

    /**
     * Returns the timer of the pulse counter (ms).
     *
     * @return integer : an integer corresponding to the timer of the pulse counter (ms)
     *
     * On failure, throws an exception or returns Y_PULSETIMER_INVALID.
     */
    public function get_pulseTimer()
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PULSETIMER_INVALID;
            }
        }
        $res = $this->_pulseTimer;
        return $res;
    }

    /**
     * Returns the parameter (sensor value, presence or pulse count) returned by the get_currentValue
     * function and callbacks.
     *
     * @return integer : a value among Y_PROXIMITYREPORTMODE_NUMERIC, Y_PROXIMITYREPORTMODE_PRESENCE and
     * Y_PROXIMITYREPORTMODE_PULSECOUNT corresponding to the parameter (sensor value, presence or pulse
     * count) returned by the get_currentValue function and callbacks
     *
     * On failure, throws an exception or returns Y_PROXIMITYREPORTMODE_INVALID.
     */
    public function get_proximityReportMode()
    {
        // $res                    is a enumPROXIMITYREPORTMODETYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PROXIMITYREPORTMODE_INVALID;
            }
        }
        $res = $this->_proximityReportMode;
        return $res;
    }

    /**
     * Changes the  parameter  type (sensor value, presence or pulse count) returned by the
     * get_currentValue function and callbacks.
     * The edge count value is limited to the 6 lowest digits. For values greater than one million, use
     * get_pulseCounter().
     *
     * @param integer $newval : a value among Y_PROXIMITYREPORTMODE_NUMERIC,
     * Y_PROXIMITYREPORTMODE_PRESENCE and Y_PROXIMITYREPORTMODE_PULSECOUNT corresponding to the  parameter
     *  type (sensor value, presence or pulse count) returned by the get_currentValue function and callbacks
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_proximityReportMode($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("proximityReportMode",$rest_val);
    }

    /**
     * Retrieves a proximity sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the proximity sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YProximity.isOnline() to test if the proximity sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a proximity sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the proximity sensor
     *
     * @return YProximity : a YProximity object allowing you to drive the proximity sensor.
     */
    public static function FindProximity($func)
    {
        // $obj                    is a YProximity;
        $obj = YFunction::_FindFromCache('Proximity', $func);
        if ($obj == null) {
            $obj = new YProximity($func);
            YFunction::_AddToCache('Proximity', $func, $obj);
        }
        return $obj;
    }

    /**
     * Resets the pulse counter value as well as its timer.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetCounter()
    {
        return $this->set_pulseCounter(0);
    }

    public function signalValue()
    { return $this->get_signalValue(); }

    public function detectionThreshold()
    { return $this->get_detectionThreshold(); }

    public function setDetectionThreshold($newval)
    { return $this->set_detectionThreshold($newval); }

    public function detectionHysteresis()
    { return $this->get_detectionHysteresis(); }

    public function setDetectionHysteresis($newval)
    { return $this->set_detectionHysteresis($newval); }

    public function presenceMinTime()
    { return $this->get_presenceMinTime(); }

    public function setPresenceMinTime($newval)
    { return $this->set_presenceMinTime($newval); }

    public function removalMinTime()
    { return $this->get_removalMinTime(); }

    public function setRemovalMinTime($newval)
    { return $this->set_removalMinTime($newval); }

    public function isPresent()
    { return $this->get_isPresent(); }

    public function lastTimeApproached()
    { return $this->get_lastTimeApproached(); }

    public function lastTimeRemoved()
    { return $this->get_lastTimeRemoved(); }

    public function pulseCounter()
    { return $this->get_pulseCounter(); }

    public function setPulseCounter($newval)
    { return $this->set_pulseCounter($newval); }

    public function pulseTimer()
    { return $this->get_pulseTimer(); }

    public function proximityReportMode()
    { return $this->get_proximityReportMode(); }

    public function setProximityReportMode($newval)
    { return $this->set_proximityReportMode($newval); }

    /**
     * Continues the enumeration of proximity sensors started using yFirstProximity().
     * Caution: You can't make any assumption about the returned proximity sensors order.
     * If you want to find a specific a proximity sensor, use Proximity.findProximity()
     * and a hardwareID or a logical name.
     *
     * @return YProximity : a pointer to a YProximity object, corresponding to
     *         a proximity sensor currently online, or a null pointer
     *         if there are no more proximity sensors to enumerate.
     */
    public function nextProximity()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindProximity($next_hwid);
    }

    /**
     * Starts the enumeration of proximity sensors currently accessible.
     * Use the method YProximity.nextProximity() to iterate on
     * next proximity sensors.
     *
     * @return YProximity : a pointer to a YProximity object, corresponding to
     *         the first proximity sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstProximity()
    {   $next_hwid = YAPI::getFirstHardwareId('Proximity');
        if($next_hwid == null) return null;
        return self::FindProximity($next_hwid);
    }

    //--- (end of YProximity implementation)

};

//--- (YProximity functions)

/**
 * Retrieves a proximity sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the proximity sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YProximity.isOnline() to test if the proximity sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a proximity sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the proximity sensor
 *
 * @return YProximity : a YProximity object allowing you to drive the proximity sensor.
 */
function yFindProximity($func)
{
    return YProximity::FindProximity($func);
}

/**
 * Starts the enumeration of proximity sensors currently accessible.
 * Use the method YProximity.nextProximity() to iterate on
 * next proximity sensors.
 *
 * @return YProximity : a pointer to a YProximity object, corresponding to
 *         the first proximity sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstProximity()
{
    return YProximity::FirstProximity();
}

//--- (end of YProximity functions)
?>