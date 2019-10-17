<?php
/*********************************************************************
 *
 *  $Id: yocto_rangefinder.php 37149 2019-09-12 21:24:53Z mvuilleu $
 *
 *  Implements YRangeFinder, the high-level API for RangeFinder functions
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

//--- (YRangeFinder return codes)
//--- (end of YRangeFinder return codes)
//--- (YRangeFinder definitions)
if(!defined('Y_RANGEFINDERMODE_DEFAULT'))    define('Y_RANGEFINDERMODE_DEFAULT',   0);
if(!defined('Y_RANGEFINDERMODE_LONG_RANGE')) define('Y_RANGEFINDERMODE_LONG_RANGE', 1);
if(!defined('Y_RANGEFINDERMODE_HIGH_ACCURACY')) define('Y_RANGEFINDERMODE_HIGH_ACCURACY', 2);
if(!defined('Y_RANGEFINDERMODE_HIGH_SPEED')) define('Y_RANGEFINDERMODE_HIGH_SPEED', 3);
if(!defined('Y_RANGEFINDERMODE_INVALID'))    define('Y_RANGEFINDERMODE_INVALID',   -1);
if(!defined('Y_TIMEFRAME_INVALID'))          define('Y_TIMEFRAME_INVALID',         YAPI_INVALID_LONG);
if(!defined('Y_QUALITY_INVALID'))            define('Y_QUALITY_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_HARDWARECALIBRATION_INVALID')) define('Y_HARDWARECALIBRATION_INVALID', YAPI_INVALID_STRING);
if(!defined('Y_CURRENTTEMPERATURE_INVALID')) define('Y_CURRENTTEMPERATURE_INVALID', YAPI_INVALID_DOUBLE);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YRangeFinder definitions)
    #--- (YRangeFinder yapiwrapper)
   #--- (end of YRangeFinder yapiwrapper)

//--- (YRangeFinder declaration)
/**
 * YRangeFinder Class: RangeFinder function interface
 *
 * The Yoctopuce class YRangeFinder allows you to use and configure Yoctopuce range finder
 * sensors. It inherits from the YSensor class the core functions to read measurements,
 * register callback functions, access the autonomous datalogger.
 * This class adds the ability to easily perform a one-point linear calibration
 * to compensate the effect of a glass or filter placed in front of the sensor.
 */
class YRangeFinder extends YSensor
{
    const RANGEFINDERMODE_DEFAULT        = 0;
    const RANGEFINDERMODE_LONG_RANGE     = 1;
    const RANGEFINDERMODE_HIGH_ACCURACY  = 2;
    const RANGEFINDERMODE_HIGH_SPEED     = 3;
    const RANGEFINDERMODE_INVALID        = -1;
    const TIMEFRAME_INVALID              = YAPI_INVALID_LONG;
    const QUALITY_INVALID                = YAPI_INVALID_UINT;
    const HARDWARECALIBRATION_INVALID    = YAPI_INVALID_STRING;
    const CURRENTTEMPERATURE_INVALID     = YAPI_INVALID_DOUBLE;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YRangeFinder declaration)

    //--- (YRangeFinder attributes)
    protected $_rangeFinderMode          = Y_RANGEFINDERMODE_INVALID;    // RangeFinderMode
    protected $_timeFrame                = Y_TIMEFRAME_INVALID;          // Time
    protected $_quality                  = Y_QUALITY_INVALID;            // Percent
    protected $_hardwareCalibration      = Y_HARDWARECALIBRATION_INVALID; // RangeFinderCalib
    protected $_currentTemperature       = Y_CURRENTTEMPERATURE_INVALID; // MeasureVal
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YRangeFinder attributes)

    function __construct($str_func)
    {
        //--- (YRangeFinder constructor)
        parent::__construct($str_func);
        $this->_className = 'RangeFinder';

        //--- (end of YRangeFinder constructor)
    }

    //--- (YRangeFinder implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'rangeFinderMode':
            $this->_rangeFinderMode = intval($val);
            return 1;
        case 'timeFrame':
            $this->_timeFrame = intval($val);
            return 1;
        case 'quality':
            $this->_quality = intval($val);
            return 1;
        case 'hardwareCalibration':
            $this->_hardwareCalibration = $val;
            return 1;
        case 'currentTemperature':
            $this->_currentTemperature = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the measured range. That unit is a string.
     * String value can be " or mm. Any other value is ignored.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     * WARNING: if a specific calibration is defined for the rangeFinder function, a
     * unit system change will probably break it.
     *
     * @param string $newval : a string corresponding to the measuring unit for the measured range
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_unit($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("unit",$rest_val);
    }

    /**
     * Returns the range finder running mode. The rangefinder running mode
     * allows you to put priority on precision, speed or maximum range.
     *
     * @return integer : a value among Y_RANGEFINDERMODE_DEFAULT, Y_RANGEFINDERMODE_LONG_RANGE,
     * Y_RANGEFINDERMODE_HIGH_ACCURACY and Y_RANGEFINDERMODE_HIGH_SPEED corresponding to the range finder running mode
     *
     * On failure, throws an exception or returns Y_RANGEFINDERMODE_INVALID.
     */
    public function get_rangeFinderMode()
    {
        // $res                    is a enumRANGEFINDERMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_RANGEFINDERMODE_INVALID;
            }
        }
        $res = $this->_rangeFinderMode;
        return $res;
    }

    /**
     * Changes the rangefinder running mode, allowing you to put priority on
     * precision, speed or maximum range.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param integer $newval : a value among Y_RANGEFINDERMODE_DEFAULT, Y_RANGEFINDERMODE_LONG_RANGE,
     * Y_RANGEFINDERMODE_HIGH_ACCURACY and Y_RANGEFINDERMODE_HIGH_SPEED corresponding to the rangefinder
     * running mode, allowing you to put priority on
     *         precision, speed or maximum range
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_rangeFinderMode($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("rangeFinderMode",$rest_val);
    }

    /**
     * Returns the time frame used to measure the distance and estimate the measure
     * reliability. The time frame is expressed in milliseconds.
     *
     * @return integer : an integer corresponding to the time frame used to measure the distance and
     * estimate the measure
     *         reliability
     *
     * On failure, throws an exception or returns Y_TIMEFRAME_INVALID.
     */
    public function get_timeFrame()
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TIMEFRAME_INVALID;
            }
        }
        $res = $this->_timeFrame;
        return $res;
    }

    /**
     * Changes the time frame used to measure the distance and estimate the measure
     * reliability. The time frame is expressed in milliseconds. A larger timeframe
     * improves stability and reliability, at the cost of higher latency, but prevents
     * the detection of events shorter than the time frame.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param integer $newval : an integer corresponding to the time frame used to measure the distance
     * and estimate the measure
     *         reliability
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_timeFrame($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("timeFrame",$rest_val);
    }

    /**
     * Returns a measure quality estimate, based on measured dispersion.
     *
     * @return integer : an integer corresponding to a measure quality estimate, based on measured dispersion
     *
     * On failure, throws an exception or returns Y_QUALITY_INVALID.
     */
    public function get_quality()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_QUALITY_INVALID;
            }
        }
        $res = $this->_quality;
        return $res;
    }

    public function get_hardwareCalibration()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_HARDWARECALIBRATION_INVALID;
            }
        }
        $res = $this->_hardwareCalibration;
        return $res;
    }

    public function set_hardwareCalibration($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("hardwareCalibration",$rest_val);
    }

    /**
     * Returns the current sensor temperature, as a floating point number.
     *
     * @return double : a floating point number corresponding to the current sensor temperature, as a
     * floating point number
     *
     * On failure, throws an exception or returns Y_CURRENTTEMPERATURE_INVALID.
     */
    public function get_currentTemperature()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENTTEMPERATURE_INVALID;
            }
        }
        $res = $this->_currentTemperature;
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
     * Retrieves a range finder for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the range finder is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YRangeFinder.isOnline() to test if the range finder is
     * indeed online at a given time. In case of ambiguity when looking for
     * a range finder by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the range finder
     *
     * @return YRangeFinder : a YRangeFinder object allowing you to drive the range finder.
     */
    public static function FindRangeFinder($func)
    {
        // $obj                    is a YRangeFinder;
        $obj = YFunction::_FindFromCache('RangeFinder', $func);
        if ($obj == null) {
            $obj = new YRangeFinder($func);
            YFunction::_AddToCache('RangeFinder', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns the temperature at the time when the latest calibration was performed.
     * This function can be used to determine if a new calibration for ambient temperature
     * is required.
     *
     * @return double : a temperature, as a floating point number.
     *         On failure, throws an exception or return YAPI_INVALID_DOUBLE.
     */
    public function get_hardwareCalibrationTemperature()
    {
        // $hwcal                  is a string;
        $hwcal = $this->get_hardwareCalibration();
        if (!(substr($hwcal, 0, 1) == '@')) {
            return YAPI_INVALID_DOUBLE;
        }
        return intVal(substr($hwcal, 1, strlen($hwcal)));
    }

    /**
     * Triggers a sensor calibration according to the current ambient temperature. That
     * calibration process needs no physical interaction with the sensor. It is performed
     * automatically at device startup, but it is recommended to start it again when the
     * temperature delta since the latest calibration exceeds 8°C.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function triggerTemperatureCalibration()
    {
        return $this->set_command('T');
    }

    /**
     * Triggers the photon detector hardware calibration.
     * This function is part of the calibration procedure to compensate for the the effect
     * of a cover glass. Make sure to read the chapter about hardware calibration for details
     * on the calibration procedure for proper results.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function triggerSpadCalibration()
    {
        return $this->set_command('S');
    }

    /**
     * Triggers the hardware offset calibration of the distance sensor.
     * This function is part of the calibration procedure to compensate for the the effect
     * of a cover glass. Make sure to read the chapter about hardware calibration for details
     * on the calibration procedure for proper results.
     *
     * @param double $targetDist : true distance of the calibration target, in mm or inches, depending
     *         on the unit selected in the device
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function triggerOffsetCalibration($targetDist)
    {
        // $distmm                 is a int;
        if ($this->get_unit() == '"') {
            $distmm = round($targetDist * 25.4);
        } else {
            $distmm = round($targetDist);
        }
        return $this->set_command(sprintf('O%d',$distmm));
    }

    /**
     * Triggers the hardware cross-talk calibration of the distance sensor.
     * This function is part of the calibration procedure to compensate for the the effect
     * of a cover glass. Make sure to read the chapter about hardware calibration for details
     * on the calibration procedure for proper results.
     *
     * @param double $targetDist : true distance of the calibration target, in mm or inches, depending
     *         on the unit selected in the device
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function triggerXTalkCalibration($targetDist)
    {
        // $distmm                 is a int;
        if ($this->get_unit() == '"') {
            $distmm = round($targetDist * 25.4);
        } else {
            $distmm = round($targetDist);
        }
        return $this->set_command(sprintf('X%d',$distmm));
    }

    /**
     * Cancels the effect of previous hardware calibration procedures to compensate
     * for cover glass, and restores factory settings.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function cancelCoverGlassCalibrations()
    {
        return $this->set_hardwareCalibration('');
    }

    public function setUnit($newval)
    { return $this->set_unit($newval); }

    public function rangeFinderMode()
    { return $this->get_rangeFinderMode(); }

    public function setRangeFinderMode($newval)
    { return $this->set_rangeFinderMode($newval); }

    public function timeFrame()
    { return $this->get_timeFrame(); }

    public function setTimeFrame($newval)
    { return $this->set_timeFrame($newval); }

    public function quality()
    { return $this->get_quality(); }

    public function hardwareCalibration()
    { return $this->get_hardwareCalibration(); }

    public function setHardwareCalibration($newval)
    { return $this->set_hardwareCalibration($newval); }

    public function currentTemperature()
    { return $this->get_currentTemperature(); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of range finders started using yFirstRangeFinder().
     * Caution: You can't make any assumption about the returned range finders order.
     * If you want to find a specific a range finder, use RangeFinder.findRangeFinder()
     * and a hardwareID or a logical name.
     *
     * @return YRangeFinder : a pointer to a YRangeFinder object, corresponding to
     *         a range finder currently online, or a null pointer
     *         if there are no more range finders to enumerate.
     */
    public function nextRangeFinder()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindRangeFinder($next_hwid);
    }

    /**
     * Starts the enumeration of range finders currently accessible.
     * Use the method YRangeFinder.nextRangeFinder() to iterate on
     * next range finders.
     *
     * @return YRangeFinder : a pointer to a YRangeFinder object, corresponding to
     *         the first range finder currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRangeFinder()
    {   $next_hwid = YAPI::getFirstHardwareId('RangeFinder');
        if($next_hwid == null) return null;
        return self::FindRangeFinder($next_hwid);
    }

    //--- (end of YRangeFinder implementation)

};

//--- (YRangeFinder functions)

/**
 * Retrieves a range finder for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the range finder is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YRangeFinder.isOnline() to test if the range finder is
 * indeed online at a given time. In case of ambiguity when looking for
 * a range finder by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the range finder
 *
 * @return YRangeFinder : a YRangeFinder object allowing you to drive the range finder.
 */
function yFindRangeFinder($func)
{
    return YRangeFinder::FindRangeFinder($func);
}

/**
 * Starts the enumeration of range finders currently accessible.
 * Use the method YRangeFinder.nextRangeFinder() to iterate on
 * next range finders.
 *
 * @return YRangeFinder : a pointer to a YRangeFinder object, corresponding to
 *         the first range finder currently online, or a null pointer
 *         if there are none.
 */
function yFirstRangeFinder()
{
    return YRangeFinder::FirstRangeFinder();
}

//--- (end of YRangeFinder functions)
?>