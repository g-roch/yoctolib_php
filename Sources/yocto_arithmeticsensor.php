<?php
/*********************************************************************
 *
 *  $Id: yocto_arithmeticsensor.php 35698 2019-06-05 17:25:12Z mvuilleu $
 *
 *  Implements YArithmeticSensor, the high-level API for ArithmeticSensor functions
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

//--- (YArithmeticSensor return codes)
//--- (end of YArithmeticSensor return codes)
//--- (YArithmeticSensor definitions)
if(!defined('Y_DESCRIPTION_INVALID'))        define('Y_DESCRIPTION_INVALID',       YAPI_INVALID_STRING);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YArithmeticSensor definitions)
    #--- (YArithmeticSensor yapiwrapper)
   #--- (end of YArithmeticSensor yapiwrapper)

//--- (YArithmeticSensor declaration)
/**
 * YArithmeticSensor Class: ArithmeticSensor function interface
 *
 * The YArithmeticSensor class can produce measurements computed using an arithmetic
 * formula based on one or more measured signals and temperature measurements.
 */
class YArithmeticSensor extends YSensor
{
    const DESCRIPTION_INVALID            = YAPI_INVALID_STRING;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YArithmeticSensor declaration)

    //--- (YArithmeticSensor attributes)
    protected $_description              = Y_DESCRIPTION_INVALID;        // Text
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YArithmeticSensor attributes)

    function __construct($str_func)
    {
        //--- (YArithmeticSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'ArithmeticSensor';

        //--- (end of YArithmeticSensor constructor)
    }

    //--- (YArithmeticSensor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'description':
            $this->_description = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the arithmetic sensor.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the arithmetic sensor
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
     * Returns a short informative description of the formula.
     *
     * @return string : a string corresponding to a short informative description of the formula
     *
     * On failure, throws an exception or returns Y_DESCRIPTION_INVALID.
     */
    public function get_description()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DESCRIPTION_INVALID;
            }
        }
        $res = $this->_description;
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
     * Retrieves an arithmetic sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the arithmetic sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YArithmeticSensor.isOnline() to test if the arithmetic sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * an arithmetic sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the arithmetic sensor
     *
     * @return YArithmeticSensor : a YArithmeticSensor object allowing you to drive the arithmetic sensor.
     */
    public static function FindArithmeticSensor($func)
    {
        // $obj                    is a YArithmeticSensor;
        $obj = YFunction::_FindFromCache('ArithmeticSensor', $func);
        if ($obj == null) {
            $obj = new YArithmeticSensor($func);
            YFunction::_AddToCache('ArithmeticSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Defines the arithmetic function by means of an algebraic expression. The expression
     * may include references to device sensors, by their physical or logical name, to
     * usual math functions and to auxiliary functions defined separately.
     *
     * @param string $expr : the algebraic expression defining the function.
     * @param string $descr : short informative description of the expression.
     *
     * @return double : the current expression value if the call succeeds.
     *
     * On failure, throws an exception or returns YAPI_INVALID_DOUBLE.
     */
    public function defineExpression($expr,$descr)
    {
        // $id                     is a str;
        // $fname                  is a str;
        // $content                is a str;
        // $data                   is a bin;
        // $diags                  is a str;
        // $resval                 is a float;
        $id = $this->get_functionId();
        $id = substr($id,  16, strlen($id) - 16);
        $fname = sprintf('arithmExpr%s.txt', $id);

        $content = sprintf('// %s'."\n".'%s', $descr, $expr);
        $data = $this->_uploadEx($fname, $content);
        $diags = $data;
        if (!(substr($diags, 0, 8) == 'Result: ')) return $this->_throw( YAPI_INVALID_ARGUMENT, $diags,YAPI_INVALID_DOUBLE);
        $resval = floatval(substr($diags,  8, strlen($diags)-8));
        return $resval;
    }

    /**
     * Retrieves the algebraic expression defining the arithmetic function, as previously
     * configured using the defineExpression function.
     *
     * @return string : a string containing the mathematical expression.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function loadExpression()
    {
        // $id                     is a str;
        // $fname                  is a str;
        // $content                is a str;
        // $idx                    is a int;
        $id = $this->get_functionId();
        $id = substr($id,  16, strlen($id) - 16);
        $fname = sprintf('arithmExpr%s.txt', $id);

        $content = $this->_download($fname);
        $idx = Ystrpos($content,''."\n".'');
        if ($idx > 0) {
            $content = substr($content,  $idx+1, strlen($content)-($idx+1));
        }
        return $content;
    }

    /**
     * Defines a auxiliary function by means of a table of reference points. Intermediate values
     * will be interpolated between specified reference points. The reference points are given
     * as pairs of floating point numbers.
     * The auxiliary function will be available for use by all ArithmeticSensor objects of the
     * device. Up to nine auxiliary function can be defined in a device, each containing up to
     * 96 reference points.
     *
     * @param string $name : auxiliary function name, up to 16 characters.
     * @param double[] $inputValues : array of floating point numbers, corresponding to the function input value.
     * @param double[] $outputValues : array of floating point numbers, corresponding to the output value
     *         desired for each of the input value, index by index.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function defineAuxiliaryFunction($name,$inputValues,$outputValues)
    {
        // $siz                    is a int;
        // $defstr                 is a str;
        // $idx                    is a int;
        // $inputVal               is a float;
        // $outputVal              is a float;
        // $fname                  is a str;
        $siz = sizeof($inputValues);
        if (!($siz > 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'auxiliary function must be defined by at least two points',YAPI_INVALID_ARGUMENT);
        if (!($siz == sizeof($outputValues))) return $this->_throw( YAPI_INVALID_ARGUMENT, 'table sizes mismatch',YAPI_INVALID_ARGUMENT);
        $defstr = '';
        $idx = 0;
        while ($idx < $siz) {
            $inputVal = $inputValues[$idx];
            $outputVal = $outputValues[$idx];
            $defstr = sprintf('%s%F:%F'."\n".'', $defstr, $inputVal, $outputVal);
            $idx = $idx + 1;
        }
        $fname = sprintf('userMap%s.txt', $name);

        return $this->_upload($fname, $defstr);
    }

    /**
     * Retrieves the reference points table defining an auxiliary function previously
     * configured using the defineAuxiliaryFunction function.
     *
     * @param string $name : auxiliary function name, up to 16 characters.
     * @param double[] $inputValues : array of floating point numbers, that is filled by the function
     *         with all the function reference input value.
     * @param double[] $outputValues : array of floating point numbers, that is filled by the function
     *         output value for each of the input value, index by index.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function loadAuxiliaryFunction($name,&$inputValues,&$outputValues)
    {
        // $fname                  is a str;
        // $defbin                 is a bin;
        // $siz                    is a int;

        $fname = sprintf('userMap%s.txt', $name);
        $defbin = $this->_download($fname);
        $siz = strlen($defbin);
        if (!($siz > 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'auxiliary function does not exist',YAPI_INVALID_ARGUMENT);
        while(sizeof($inputValues) > 0) { array_pop($inputValues); };
        while(sizeof($outputValues) > 0) { array_pop($outputValues); };
        // FIXME: decode line by line
        return YAPI_SUCCESS;
    }

    public function setUnit($newval)
    { return $this->set_unit($newval); }

    public function description()
    { return $this->get_description(); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of arithmetic sensors started using yFirstArithmeticSensor().
     * Caution: You can't make any assumption about the returned arithmetic sensors order.
     * If you want to find a specific an arithmetic sensor, use ArithmeticSensor.findArithmeticSensor()
     * and a hardwareID or a logical name.
     *
     * @return YArithmeticSensor : a pointer to a YArithmeticSensor object, corresponding to
     *         an arithmetic sensor currently online, or a null pointer
     *         if there are no more arithmetic sensors to enumerate.
     */
    public function nextArithmeticSensor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindArithmeticSensor($next_hwid);
    }

    /**
     * Starts the enumeration of arithmetic sensors currently accessible.
     * Use the method YArithmeticSensor.nextArithmeticSensor() to iterate on
     * next arithmetic sensors.
     *
     * @return YArithmeticSensor : a pointer to a YArithmeticSensor object, corresponding to
     *         the first arithmetic sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstArithmeticSensor()
    {   $next_hwid = YAPI::getFirstHardwareId('ArithmeticSensor');
        if($next_hwid == null) return null;
        return self::FindArithmeticSensor($next_hwid);
    }

    //--- (end of YArithmeticSensor implementation)

};

//--- (YArithmeticSensor functions)

/**
 * Retrieves an arithmetic sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the arithmetic sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YArithmeticSensor.isOnline() to test if the arithmetic sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * an arithmetic sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the arithmetic sensor
 *
 * @return YArithmeticSensor : a YArithmeticSensor object allowing you to drive the arithmetic sensor.
 */
function yFindArithmeticSensor($func)
{
    return YArithmeticSensor::FindArithmeticSensor($func);
}

/**
 * Starts the enumeration of arithmetic sensors currently accessible.
 * Use the method YArithmeticSensor.nextArithmeticSensor() to iterate on
 * next arithmetic sensors.
 *
 * @return YArithmeticSensor : a pointer to a YArithmeticSensor object, corresponding to
 *         the first arithmetic sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstArithmeticSensor()
{
    return YArithmeticSensor::FirstArithmeticSensor();
}

//--- (end of YArithmeticSensor functions)
?>