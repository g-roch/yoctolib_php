<?php
/*********************************************************************
 *
 *  $Id: yocto_colorled.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YColorLed, the high-level API for ColorLed functions
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

//--- (YColorLed return codes)
//--- (end of YColorLed return codes)
//--- (YColorLed definitions)
if(!defined('Y_RGBCOLOR_INVALID'))           define('Y_RGBCOLOR_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_HSLCOLOR_INVALID'))           define('Y_HSLCOLOR_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_RGBMOVE_INVALID'))            define('Y_RGBMOVE_INVALID',           null);
if(!defined('Y_HSLMOVE_INVALID'))            define('Y_HSLMOVE_INVALID',           null);
if(!defined('Y_RGBCOLORATPOWERON_INVALID'))  define('Y_RGBCOLORATPOWERON_INVALID', YAPI_INVALID_UINT);
if(!defined('Y_BLINKSEQSIZE_INVALID'))       define('Y_BLINKSEQSIZE_INVALID',      YAPI_INVALID_UINT);
if(!defined('Y_BLINKSEQMAXSIZE_INVALID'))    define('Y_BLINKSEQMAXSIZE_INVALID',   YAPI_INVALID_UINT);
if(!defined('Y_BLINKSEQSIGNATURE_INVALID'))  define('Y_BLINKSEQSIGNATURE_INVALID', YAPI_INVALID_UINT);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YColorLed definitions)
    #--- (YColorLed yapiwrapper)
   #--- (end of YColorLed yapiwrapper)

//--- (YColorLed declaration)
/**
 * YColorLed Class: ColorLed function interface
 *
 * The Yoctopuce application programming interface
 * allows you to drive a color LED using RGB coordinates as well as HSL coordinates.
 * The module performs all conversions form RGB to HSL automatically. It is then
 * self-evident to turn on a LED with a given hue and to progressively vary its
 * saturation or lightness. If needed, you can find more information on the
 * difference between RGB and HSL in the section following this one.
 */
class YColorLed extends YFunction
{
    const RGBCOLOR_INVALID               = YAPI_INVALID_UINT;
    const HSLCOLOR_INVALID               = YAPI_INVALID_UINT;
    const RGBMOVE_INVALID                = null;
    const HSLMOVE_INVALID                = null;
    const RGBCOLORATPOWERON_INVALID      = YAPI_INVALID_UINT;
    const BLINKSEQSIZE_INVALID           = YAPI_INVALID_UINT;
    const BLINKSEQMAXSIZE_INVALID        = YAPI_INVALID_UINT;
    const BLINKSEQSIGNATURE_INVALID      = YAPI_INVALID_UINT;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YColorLed declaration)

    //--- (YColorLed attributes)
    protected $_rgbColor                 = Y_RGBCOLOR_INVALID;           // U24Color
    protected $_hslColor                 = Y_HSLCOLOR_INVALID;           // U24Color
    protected $_rgbMove                  = Y_RGBMOVE_INVALID;            // Move
    protected $_hslMove                  = Y_HSLMOVE_INVALID;            // Move
    protected $_rgbColorAtPowerOn        = Y_RGBCOLORATPOWERON_INVALID;  // U24Color
    protected $_blinkSeqSize             = Y_BLINKSEQSIZE_INVALID;       // UInt31
    protected $_blinkSeqMaxSize          = Y_BLINKSEQMAXSIZE_INVALID;    // UInt31
    protected $_blinkSeqSignature        = Y_BLINKSEQSIGNATURE_INVALID;  // UInt31
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YColorLed attributes)

    function __construct($str_func)
    {
        //--- (YColorLed constructor)
        parent::__construct($str_func);
        $this->_className = 'ColorLed';

        //--- (end of YColorLed constructor)
    }

    //--- (YColorLed implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'rgbColor':
            $this->_rgbColor = intval($val);
            return 1;
        case 'hslColor':
            $this->_hslColor = intval($val);
            return 1;
        case 'rgbMove':
            $this->_rgbMove = $val;
            return 1;
        case 'hslMove':
            $this->_hslMove = $val;
            return 1;
        case 'rgbColorAtPowerOn':
            $this->_rgbColorAtPowerOn = intval($val);
            return 1;
        case 'blinkSeqSize':
            $this->_blinkSeqSize = intval($val);
            return 1;
        case 'blinkSeqMaxSize':
            $this->_blinkSeqMaxSize = intval($val);
            return 1;
        case 'blinkSeqSignature':
            $this->_blinkSeqSignature = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current RGB color of the LED.
     *
     * @return integer : an integer corresponding to the current RGB color of the LED
     *
     * On failure, throws an exception or returns Y_RGBCOLOR_INVALID.
     */
    public function get_rgbColor()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_RGBCOLOR_INVALID;
            }
        }
        $res = $this->_rgbColor;
        return $res;
    }

    /**
     * Changes the current color of the LED, using an RGB color. Encoding is done as follows: 0xRRGGBB.
     *
     * @param integer $newval : an integer corresponding to the current color of the LED, using an RGB color
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_rgbColor($newval)
    {
        $rest_val = sprintf("0x%06x", $newval);
        return $this->_setAttr("rgbColor",$rest_val);
    }

    /**
     * Returns the current HSL color of the LED.
     *
     * @return integer : an integer corresponding to the current HSL color of the LED
     *
     * On failure, throws an exception or returns Y_HSLCOLOR_INVALID.
     */
    public function get_hslColor()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_HSLCOLOR_INVALID;
            }
        }
        $res = $this->_hslColor;
        return $res;
    }

    /**
     * Changes the current color of the LED, using a color HSL. Encoding is done as follows: 0xHHSSLL.
     *
     * @param integer $newval : an integer corresponding to the current color of the LED, using a color HSL
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_hslColor($newval)
    {
        $rest_val = sprintf("0x%06x", $newval);
        return $this->_setAttr("hslColor",$rest_val);
    }

    public function get_rgbMove()
    {
        // $res                    is a YMove;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_RGBMOVE_INVALID;
            }
        }
        $res = $this->_rgbMove;
        return $res;
    }

    public function set_rgbMove($newval)
    {
        $rest_val = strval($newval["target"]).':'.strval($newval["ms"]);
        return $this->_setAttr("rgbMove",$rest_val);
    }

    /**
     * Performs a smooth transition in the RGB color space between the current color and a target color.
     *
     * @param rgb_target  : desired RGB color at the end of the transition
     * @param integer $ms_duration : duration of the transition, in millisecond
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function rgbMove($rgb_target,$ms_duration)
    {
        $rest_val = strval($rgb_target).':'.strval($ms_duration);
        return $this->_setAttr("rgbMove",$rest_val);
    }

    public function get_hslMove()
    {
        // $res                    is a YMove;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_HSLMOVE_INVALID;
            }
        }
        $res = $this->_hslMove;
        return $res;
    }

    public function set_hslMove($newval)
    {
        $rest_val = strval($newval["target"]).':'.strval($newval["ms"]);
        return $this->_setAttr("hslMove",$rest_val);
    }

    /**
     * Performs a smooth transition in the HSL color space between the current color and a target color.
     *
     * @param hsl_target  : desired HSL color at the end of the transition
     * @param integer $ms_duration : duration of the transition, in millisecond
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function hslMove($hsl_target,$ms_duration)
    {
        $rest_val = strval($hsl_target).':'.strval($ms_duration);
        return $this->_setAttr("hslMove",$rest_val);
    }

    /**
     * Returns the configured color to be displayed when the module is turned on.
     *
     * @return integer : an integer corresponding to the configured color to be displayed when the module is turned on
     *
     * On failure, throws an exception or returns Y_RGBCOLORATPOWERON_INVALID.
     */
    public function get_rgbColorAtPowerOn()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_RGBCOLORATPOWERON_INVALID;
            }
        }
        $res = $this->_rgbColorAtPowerOn;
        return $res;
    }

    /**
     * Changes the color that the LED will display by default when the module is turned on.
     *
     * @param integer $newval : an integer corresponding to the color that the LED will display by default
     * when the module is turned on
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_rgbColorAtPowerOn($newval)
    {
        $rest_val = sprintf("0x%06x", $newval);
        return $this->_setAttr("rgbColorAtPowerOn",$rest_val);
    }

    /**
     * Returns the current length of the blinking sequence.
     *
     * @return integer : an integer corresponding to the current length of the blinking sequence
     *
     * On failure, throws an exception or returns Y_BLINKSEQSIZE_INVALID.
     */
    public function get_blinkSeqSize()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BLINKSEQSIZE_INVALID;
            }
        }
        $res = $this->_blinkSeqSize;
        return $res;
    }

    /**
     * Returns the maximum length of the blinking sequence.
     *
     * @return integer : an integer corresponding to the maximum length of the blinking sequence
     *
     * On failure, throws an exception or returns Y_BLINKSEQMAXSIZE_INVALID.
     */
    public function get_blinkSeqMaxSize()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BLINKSEQMAXSIZE_INVALID;
            }
        }
        $res = $this->_blinkSeqMaxSize;
        return $res;
    }

    /**
     * Return the blinking sequence signature. Since blinking
     * sequences cannot be read from the device, this can be used
     * to detect if a specific blinking sequence is already
     * programmed.
     *
     * @return integer : an integer
     *
     * On failure, throws an exception or returns Y_BLINKSEQSIGNATURE_INVALID.
     */
    public function get_blinkSeqSignature()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BLINKSEQSIGNATURE_INVALID;
            }
        }
        $res = $this->_blinkSeqSignature;
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
     * Retrieves an RGB LED for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the RGB LED is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YColorLed.isOnline() to test if the RGB LED is
     * indeed online at a given time. In case of ambiguity when looking for
     * an RGB LED by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the RGB LED
     *
     * @return YColorLed : a YColorLed object allowing you to drive the RGB LED.
     */
    public static function FindColorLed($func)
    {
        // $obj                    is a YColorLed;
        $obj = YFunction::_FindFromCache('ColorLed', $func);
        if ($obj == null) {
            $obj = new YColorLed($func);
            YFunction::_AddToCache('ColorLed', $func, $obj);
        }
        return $obj;
    }

    public function sendCommand($command)
    {
        return $this->set_command($command);
    }

    /**
     * Add a new transition to the blinking sequence, the move will
     * be performed in the HSL space.
     *
     * @param integer $HSLcolor : desired HSL color when the transition is completed
     * @param integer $msDelay : duration of the color transition, in milliseconds.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function addHslMoveToBlinkSeq($HSLcolor,$msDelay)
    {
        return $this->sendCommand(sprintf('H%d,%d',$HSLcolor,$msDelay));
    }

    /**
     * Adds a new transition to the blinking sequence, the move is
     * performed in the RGB space.
     *
     * @param integer $RGBcolor : desired RGB color when the transition is completed
     * @param integer $msDelay : duration of the color transition, in milliseconds.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function addRgbMoveToBlinkSeq($RGBcolor,$msDelay)
    {
        return $this->sendCommand(sprintf('R%d,%d',$RGBcolor,$msDelay));
    }

    /**
     * Starts the preprogrammed blinking sequence. The sequence is
     * run in a loop until it is stopped by stopBlinkSeq or an explicit
     * change.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function startBlinkSeq()
    {
        return $this->sendCommand('S');
    }

    /**
     * Stops the preprogrammed blinking sequence.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function stopBlinkSeq()
    {
        return $this->sendCommand('X');
    }

    /**
     * Resets the preprogrammed blinking sequence.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function resetBlinkSeq()
    {
        return $this->sendCommand('Z');
    }

    public function rgbColor()
    { return $this->get_rgbColor(); }

    public function setRgbColor($newval)
    { return $this->set_rgbColor($newval); }

    public function hslColor()
    { return $this->get_hslColor(); }

    public function setHslColor($newval)
    { return $this->set_hslColor($newval); }

    public function setRgbMove($newval)
    { return $this->set_rgbMove($newval); }

    public function setHslMove($newval)
    { return $this->set_hslMove($newval); }

    public function rgbColorAtPowerOn()
    { return $this->get_rgbColorAtPowerOn(); }

    public function setRgbColorAtPowerOn($newval)
    { return $this->set_rgbColorAtPowerOn($newval); }

    public function blinkSeqSize()
    { return $this->get_blinkSeqSize(); }

    public function blinkSeqMaxSize()
    { return $this->get_blinkSeqMaxSize(); }

    public function blinkSeqSignature()
    { return $this->get_blinkSeqSignature(); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of RGB LEDs started using yFirstColorLed().
     * Caution: You can't make any assumption about the returned RGB LEDs order.
     * If you want to find a specific an RGB LED, use ColorLed.findColorLed()
     * and a hardwareID or a logical name.
     *
     * @return YColorLed : a pointer to a YColorLed object, corresponding to
     *         an RGB LED currently online, or a null pointer
     *         if there are no more RGB LEDs to enumerate.
     */
    public function nextColorLed()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindColorLed($next_hwid);
    }

    /**
     * Starts the enumeration of RGB LEDs currently accessible.
     * Use the method YColorLed.nextColorLed() to iterate on
     * next RGB LEDs.
     *
     * @return YColorLed : a pointer to a YColorLed object, corresponding to
     *         the first RGB LED currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstColorLed()
    {   $next_hwid = YAPI::getFirstHardwareId('ColorLed');
        if($next_hwid == null) return null;
        return self::FindColorLed($next_hwid);
    }

    //--- (end of YColorLed implementation)

};

//--- (YColorLed functions)

/**
 * Retrieves an RGB LED for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the RGB LED is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YColorLed.isOnline() to test if the RGB LED is
 * indeed online at a given time. In case of ambiguity when looking for
 * an RGB LED by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the RGB LED
 *
 * @return YColorLed : a YColorLed object allowing you to drive the RGB LED.
 */
function yFindColorLed($func)
{
    return YColorLed::FindColorLed($func);
}

/**
 * Starts the enumeration of RGB LEDs currently accessible.
 * Use the method YColorLed.nextColorLed() to iterate on
 * next RGB LEDs.
 *
 * @return YColorLed : a pointer to a YColorLed object, corresponding to
 *         the first RGB LED currently online, or a null pointer
 *         if there are none.
 */
function yFirstColorLed()
{
    return YColorLed::FirstColorLed();
}

//--- (end of YColorLed functions)
?>