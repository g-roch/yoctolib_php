<?php
/*********************************************************************
 *
 *  $Id: yocto_quadraturedecoder.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YQuadratureDecoder, the high-level API for QuadratureDecoder functions
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

//--- (YQuadratureDecoder return codes)
//--- (end of YQuadratureDecoder return codes)
//--- (YQuadratureDecoder definitions)
if(!defined('Y_DECODING_OFF'))               define('Y_DECODING_OFF',              0);
if(!defined('Y_DECODING_ON'))                define('Y_DECODING_ON',               1);
if(!defined('Y_DECODING_INVALID'))           define('Y_DECODING_INVALID',          -1);
if(!defined('Y_SPEED_INVALID'))              define('Y_SPEED_INVALID',             YAPI_INVALID_DOUBLE);
//--- (end of YQuadratureDecoder definitions)
    #--- (YQuadratureDecoder yapiwrapper)
   #--- (end of YQuadratureDecoder yapiwrapper)

//--- (YQuadratureDecoder declaration)
/**
 * YQuadratureDecoder Class: QuadratureDecoder function interface
 *
 * The class YQuadratureDecoder allows you to decode a two-wire signal produced by a
 * quadrature encoder. It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, to access the autonomous datalogger.
 */
class YQuadratureDecoder extends YSensor
{
    const SPEED_INVALID                  = YAPI_INVALID_DOUBLE;
    const DECODING_OFF                   = 0;
    const DECODING_ON                    = 1;
    const DECODING_INVALID               = -1;
    //--- (end of YQuadratureDecoder declaration)

    //--- (YQuadratureDecoder attributes)
    protected $_speed                    = Y_SPEED_INVALID;              // MeasureVal
    protected $_decoding                 = Y_DECODING_INVALID;           // OnOff
    //--- (end of YQuadratureDecoder attributes)

    function __construct($str_func)
    {
        //--- (YQuadratureDecoder constructor)
        parent::__construct($str_func);
        $this->_className = 'QuadratureDecoder';

        //--- (end of YQuadratureDecoder constructor)
    }

    //--- (YQuadratureDecoder implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'speed':
            $this->_speed = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'decoding':
            $this->_decoding = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current expected position of the quadrature decoder.
     * Invoking this function implicitly activates the quadrature decoder.
     *
     * @param double $newval : a floating point number corresponding to the current expected position of
     * the quadrature decoder
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentValue($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue",$rest_val);
    }

    /**
     * Returns the increments frequency, in Hz.
     *
     * @return double : a floating point number corresponding to the increments frequency, in Hz
     *
     * On failure, throws an exception or returns Y_SPEED_INVALID.
     */
    public function get_speed()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_SPEED_INVALID;
            }
        }
        $res = $this->_speed;
        return $res;
    }

    /**
     * Returns the current activation state of the quadrature decoder.
     *
     * @return integer : either Y_DECODING_OFF or Y_DECODING_ON, according to the current activation state
     * of the quadrature decoder
     *
     * On failure, throws an exception or returns Y_DECODING_INVALID.
     */
    public function get_decoding()
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DECODING_INVALID;
            }
        }
        $res = $this->_decoding;
        return $res;
    }

    /**
     * Changes the activation state of the quadrature decoder.
     *
     * @param integer $newval : either Y_DECODING_OFF or Y_DECODING_ON, according to the activation state
     * of the quadrature decoder
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_decoding($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("decoding",$rest_val);
    }

    /**
     * Retrieves a quadrature decoder for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the quadrature decoder is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YQuadratureDecoder.isOnline() to test if the quadrature decoder is
     * indeed online at a given time. In case of ambiguity when looking for
     * a quadrature decoder by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the quadrature decoder
     *
     * @return YQuadratureDecoder : a YQuadratureDecoder object allowing you to drive the quadrature decoder.
     */
    public static function FindQuadratureDecoder($func)
    {
        // $obj                    is a YQuadratureDecoder;
        $obj = YFunction::_FindFromCache('QuadratureDecoder', $func);
        if ($obj == null) {
            $obj = new YQuadratureDecoder($func);
            YFunction::_AddToCache('QuadratureDecoder', $func, $obj);
        }
        return $obj;
    }

    public function setCurrentValue($newval)
    { return $this->set_currentValue($newval); }

    public function speed()
    { return $this->get_speed(); }

    public function decoding()
    { return $this->get_decoding(); }

    public function setDecoding($newval)
    { return $this->set_decoding($newval); }

    /**
     * Continues the enumeration of quadrature decoders started using yFirstQuadratureDecoder().
     * Caution: You can't make any assumption about the returned quadrature decoders order.
     * If you want to find a specific a quadrature decoder, use QuadratureDecoder.findQuadratureDecoder()
     * and a hardwareID or a logical name.
     *
     * @return YQuadratureDecoder : a pointer to a YQuadratureDecoder object, corresponding to
     *         a quadrature decoder currently online, or a null pointer
     *         if there are no more quadrature decoders to enumerate.
     */
    public function nextQuadratureDecoder()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindQuadratureDecoder($next_hwid);
    }

    /**
     * Starts the enumeration of quadrature decoders currently accessible.
     * Use the method YQuadratureDecoder.nextQuadratureDecoder() to iterate on
     * next quadrature decoders.
     *
     * @return YQuadratureDecoder : a pointer to a YQuadratureDecoder object, corresponding to
     *         the first quadrature decoder currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstQuadratureDecoder()
    {   $next_hwid = YAPI::getFirstHardwareId('QuadratureDecoder');
        if($next_hwid == null) return null;
        return self::FindQuadratureDecoder($next_hwid);
    }

    //--- (end of YQuadratureDecoder implementation)

};

//--- (YQuadratureDecoder functions)

/**
 * Retrieves a quadrature decoder for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the quadrature decoder is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YQuadratureDecoder.isOnline() to test if the quadrature decoder is
 * indeed online at a given time. In case of ambiguity when looking for
 * a quadrature decoder by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the quadrature decoder
 *
 * @return YQuadratureDecoder : a YQuadratureDecoder object allowing you to drive the quadrature decoder.
 */
function yFindQuadratureDecoder($func)
{
    return YQuadratureDecoder::FindQuadratureDecoder($func);
}

/**
 * Starts the enumeration of quadrature decoders currently accessible.
 * Use the method YQuadratureDecoder.nextQuadratureDecoder() to iterate on
 * next quadrature decoders.
 *
 * @return YQuadratureDecoder : a pointer to a YQuadratureDecoder object, corresponding to
 *         the first quadrature decoder currently online, or a null pointer
 *         if there are none.
 */
function yFirstQuadratureDecoder()
{
    return YQuadratureDecoder::FirstQuadratureDecoder();
}

//--- (end of YQuadratureDecoder functions)
?>