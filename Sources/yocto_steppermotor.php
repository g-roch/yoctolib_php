<?php
/*********************************************************************
 *
 *  $Id: yocto_steppermotor.php 33716 2018-12-14 14:21:46Z seb $
 *
 *  Implements YStepperMotor, the high-level API for StepperMotor functions
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

//--- (YStepperMotor return codes)
//--- (end of YStepperMotor return codes)
//--- (YStepperMotor definitions)
if(!defined('Y_MOTORSTATE_ABSENT'))          define('Y_MOTORSTATE_ABSENT',         0);
if(!defined('Y_MOTORSTATE_ALERT'))           define('Y_MOTORSTATE_ALERT',          1);
if(!defined('Y_MOTORSTATE_HI_Z'))            define('Y_MOTORSTATE_HI_Z',           2);
if(!defined('Y_MOTORSTATE_STOP'))            define('Y_MOTORSTATE_STOP',           3);
if(!defined('Y_MOTORSTATE_RUN'))             define('Y_MOTORSTATE_RUN',            4);
if(!defined('Y_MOTORSTATE_BATCH'))           define('Y_MOTORSTATE_BATCH',          5);
if(!defined('Y_MOTORSTATE_INVALID'))         define('Y_MOTORSTATE_INVALID',        -1);
if(!defined('Y_STEPPING_MICROSTEP16'))       define('Y_STEPPING_MICROSTEP16',      0);
if(!defined('Y_STEPPING_MICROSTEP8'))        define('Y_STEPPING_MICROSTEP8',       1);
if(!defined('Y_STEPPING_MICROSTEP4'))        define('Y_STEPPING_MICROSTEP4',       2);
if(!defined('Y_STEPPING_HALFSTEP'))          define('Y_STEPPING_HALFSTEP',         3);
if(!defined('Y_STEPPING_FULLSTEP'))          define('Y_STEPPING_FULLSTEP',         4);
if(!defined('Y_STEPPING_INVALID'))           define('Y_STEPPING_INVALID',          -1);
if(!defined('Y_DIAGS_INVALID'))              define('Y_DIAGS_INVALID',             YAPI_INVALID_UINT);
if(!defined('Y_STEPPOS_INVALID'))            define('Y_STEPPOS_INVALID',           YAPI_INVALID_DOUBLE);
if(!defined('Y_SPEED_INVALID'))              define('Y_SPEED_INVALID',             YAPI_INVALID_DOUBLE);
if(!defined('Y_PULLINSPEED_INVALID'))        define('Y_PULLINSPEED_INVALID',       YAPI_INVALID_DOUBLE);
if(!defined('Y_MAXACCEL_INVALID'))           define('Y_MAXACCEL_INVALID',          YAPI_INVALID_DOUBLE);
if(!defined('Y_MAXSPEED_INVALID'))           define('Y_MAXSPEED_INVALID',          YAPI_INVALID_DOUBLE);
if(!defined('Y_OVERCURRENT_INVALID'))        define('Y_OVERCURRENT_INVALID',       YAPI_INVALID_UINT);
if(!defined('Y_TCURRSTOP_INVALID'))          define('Y_TCURRSTOP_INVALID',         YAPI_INVALID_UINT);
if(!defined('Y_TCURRRUN_INVALID'))           define('Y_TCURRRUN_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_ALERTMODE_INVALID'))          define('Y_ALERTMODE_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_AUXMODE_INVALID'))            define('Y_AUXMODE_INVALID',           YAPI_INVALID_STRING);
if(!defined('Y_AUXSIGNAL_INVALID'))          define('Y_AUXSIGNAL_INVALID',         YAPI_INVALID_INT);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YStepperMotor definitions)
    #--- (YStepperMotor yapiwrapper)
   #--- (end of YStepperMotor yapiwrapper)

//--- (YStepperMotor declaration)
/**
 * YStepperMotor Class: StepperMotor function interface
 *
 * The Yoctopuce application programming interface allows you to drive a stepper motor.
 */
class YStepperMotor extends YFunction
{
    const MOTORSTATE_ABSENT              = 0;
    const MOTORSTATE_ALERT               = 1;
    const MOTORSTATE_HI_Z                = 2;
    const MOTORSTATE_STOP                = 3;
    const MOTORSTATE_RUN                 = 4;
    const MOTORSTATE_BATCH               = 5;
    const MOTORSTATE_INVALID             = -1;
    const DIAGS_INVALID                  = YAPI_INVALID_UINT;
    const STEPPOS_INVALID                = YAPI_INVALID_DOUBLE;
    const SPEED_INVALID                  = YAPI_INVALID_DOUBLE;
    const PULLINSPEED_INVALID            = YAPI_INVALID_DOUBLE;
    const MAXACCEL_INVALID               = YAPI_INVALID_DOUBLE;
    const MAXSPEED_INVALID               = YAPI_INVALID_DOUBLE;
    const STEPPING_MICROSTEP16           = 0;
    const STEPPING_MICROSTEP8            = 1;
    const STEPPING_MICROSTEP4            = 2;
    const STEPPING_HALFSTEP              = 3;
    const STEPPING_FULLSTEP              = 4;
    const STEPPING_INVALID               = -1;
    const OVERCURRENT_INVALID            = YAPI_INVALID_UINT;
    const TCURRSTOP_INVALID              = YAPI_INVALID_UINT;
    const TCURRRUN_INVALID               = YAPI_INVALID_UINT;
    const ALERTMODE_INVALID              = YAPI_INVALID_STRING;
    const AUXMODE_INVALID                = YAPI_INVALID_STRING;
    const AUXSIGNAL_INVALID              = YAPI_INVALID_INT;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YStepperMotor declaration)

    //--- (YStepperMotor attributes)
    protected $_motorState               = Y_MOTORSTATE_INVALID;         // StepperState
    protected $_diags                    = Y_DIAGS_INVALID;              // StepperDiags
    protected $_stepPos                  = Y_STEPPOS_INVALID;            // StepPos
    protected $_speed                    = Y_SPEED_INVALID;              // MeasureVal
    protected $_pullinSpeed              = Y_PULLINSPEED_INVALID;        // MeasureVal
    protected $_maxAccel                 = Y_MAXACCEL_INVALID;           // MeasureVal
    protected $_maxSpeed                 = Y_MAXSPEED_INVALID;           // MeasureVal
    protected $_stepping                 = Y_STEPPING_INVALID;           // SteppingMode
    protected $_overcurrent              = Y_OVERCURRENT_INVALID;        // UInt31
    protected $_tCurrStop                = Y_TCURRSTOP_INVALID;          // UInt31
    protected $_tCurrRun                 = Y_TCURRRUN_INVALID;           // UInt31
    protected $_alertMode                = Y_ALERTMODE_INVALID;          // AlertMode
    protected $_auxMode                  = Y_AUXMODE_INVALID;            // AuxMode
    protected $_auxSignal                = Y_AUXSIGNAL_INVALID;          // Int
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YStepperMotor attributes)

    function __construct($str_func)
    {
        //--- (YStepperMotor constructor)
        parent::__construct($str_func);
        $this->_className = 'StepperMotor';

        //--- (end of YStepperMotor constructor)
    }

    //--- (YStepperMotor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'motorState':
            $this->_motorState = intval($val);
            return 1;
        case 'diags':
            $this->_diags = intval($val);
            return 1;
        case 'stepPos':
            $this->_stepPos = $val / 16.0;
            return 1;
        case 'speed':
            $this->_speed = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'pullinSpeed':
            $this->_pullinSpeed = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'maxAccel':
            $this->_maxAccel = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'maxSpeed':
            $this->_maxSpeed = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'stepping':
            $this->_stepping = intval($val);
            return 1;
        case 'overcurrent':
            $this->_overcurrent = intval($val);
            return 1;
        case 'tCurrStop':
            $this->_tCurrStop = intval($val);
            return 1;
        case 'tCurrRun':
            $this->_tCurrRun = intval($val);
            return 1;
        case 'alertMode':
            $this->_alertMode = $val;
            return 1;
        case 'auxMode':
            $this->_auxMode = $val;
            return 1;
        case 'auxSignal':
            $this->_auxSignal = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the motor working state.
     *
     * @return integer : a value among Y_MOTORSTATE_ABSENT, Y_MOTORSTATE_ALERT, Y_MOTORSTATE_HI_Z,
     * Y_MOTORSTATE_STOP, Y_MOTORSTATE_RUN and Y_MOTORSTATE_BATCH corresponding to the motor working state
     *
     * On failure, throws an exception or returns Y_MOTORSTATE_INVALID.
     */
    public function get_motorState()
    {
        // $res                    is a enumSTEPPERSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MOTORSTATE_INVALID;
            }
        }
        $res = $this->_motorState;
        return $res;
    }

    /**
     * Returns the stepper motor controller diagnostics, as a bitmap.
     *
     * @return integer : an integer corresponding to the stepper motor controller diagnostics, as a bitmap
     *
     * On failure, throws an exception or returns Y_DIAGS_INVALID.
     */
    public function get_diags()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DIAGS_INVALID;
            }
        }
        $res = $this->_diags;
        return $res;
    }

    /**
     * Changes the current logical motor position, measured in steps.
     * This command does not cause any motor move, as its purpose is only to setup
     * the origin of the position counter. The fractional part of the position,
     * that corresponds to the physical position of the rotor, is not changed.
     * To trigger a motor move, use methods moveTo() or moveRel()
     * instead.
     *
     * @param double $newval : a floating point number corresponding to the current logical motor
     * position, measured in steps
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_stepPos($newval)
    {
        $rest_val = strval(round($newval * 100.0)/100.0);
        return $this->_setAttr("stepPos",$rest_val);
    }

    /**
     * Returns the current logical motor position, measured in steps.
     * The value may include a fractional part when micro-stepping is in use.
     *
     * @return double : a floating point number corresponding to the current logical motor position, measured in steps
     *
     * On failure, throws an exception or returns Y_STEPPOS_INVALID.
     */
    public function get_stepPos()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_STEPPOS_INVALID;
            }
        }
        $res = $this->_stepPos;
        return $res;
    }

    /**
     * Returns current motor speed, measured in steps per second.
     * To change speed, use method changeSpeed().
     *
     * @return double : a floating point number corresponding to current motor speed, measured in steps per second
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
     * Changes the motor speed immediately reachable from stop state, measured in steps per second.
     *
     * @param double $newval : a floating point number corresponding to the motor speed immediately
     * reachable from stop state, measured in steps per second
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_pullinSpeed($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("pullinSpeed",$rest_val);
    }

    /**
     * Returns the motor speed immediately reachable from stop state, measured in steps per second.
     *
     * @return double : a floating point number corresponding to the motor speed immediately reachable
     * from stop state, measured in steps per second
     *
     * On failure, throws an exception or returns Y_PULLINSPEED_INVALID.
     */
    public function get_pullinSpeed()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PULLINSPEED_INVALID;
            }
        }
        $res = $this->_pullinSpeed;
        return $res;
    }

    /**
     * Changes the maximal motor acceleration, measured in steps per second^2.
     *
     * @param double $newval : a floating point number corresponding to the maximal motor acceleration,
     * measured in steps per second^2
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maxAccel($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("maxAccel",$rest_val);
    }

    /**
     * Returns the maximal motor acceleration, measured in steps per second^2.
     *
     * @return double : a floating point number corresponding to the maximal motor acceleration, measured
     * in steps per second^2
     *
     * On failure, throws an exception or returns Y_MAXACCEL_INVALID.
     */
    public function get_maxAccel()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MAXACCEL_INVALID;
            }
        }
        $res = $this->_maxAccel;
        return $res;
    }

    /**
     * Changes the maximal motor speed, measured in steps per second.
     *
     * @param double $newval : a floating point number corresponding to the maximal motor speed, measured
     * in steps per second
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maxSpeed($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("maxSpeed",$rest_val);
    }

    /**
     * Returns the maximal motor speed, measured in steps per second.
     *
     * @return double : a floating point number corresponding to the maximal motor speed, measured in steps per second
     *
     * On failure, throws an exception or returns Y_MAXSPEED_INVALID.
     */
    public function get_maxSpeed()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_MAXSPEED_INVALID;
            }
        }
        $res = $this->_maxSpeed;
        return $res;
    }

    /**
     * Returns the stepping mode used to drive the motor.
     *
     * @return integer : a value among Y_STEPPING_MICROSTEP16, Y_STEPPING_MICROSTEP8,
     * Y_STEPPING_MICROSTEP4, Y_STEPPING_HALFSTEP and Y_STEPPING_FULLSTEP corresponding to the stepping
     * mode used to drive the motor
     *
     * On failure, throws an exception or returns Y_STEPPING_INVALID.
     */
    public function get_stepping()
    {
        // $res                    is a enumSTEPPINGMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_STEPPING_INVALID;
            }
        }
        $res = $this->_stepping;
        return $res;
    }

    /**
     * Changes the stepping mode used to drive the motor.
     *
     * @param integer $newval : a value among Y_STEPPING_MICROSTEP16, Y_STEPPING_MICROSTEP8,
     * Y_STEPPING_MICROSTEP4, Y_STEPPING_HALFSTEP and Y_STEPPING_FULLSTEP corresponding to the stepping
     * mode used to drive the motor
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_stepping($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("stepping",$rest_val);
    }

    /**
     * Returns the overcurrent alert and emergency stop threshold, measured in mA.
     *
     * @return integer : an integer corresponding to the overcurrent alert and emergency stop threshold, measured in mA
     *
     * On failure, throws an exception or returns Y_OVERCURRENT_INVALID.
     */
    public function get_overcurrent()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_OVERCURRENT_INVALID;
            }
        }
        $res = $this->_overcurrent;
        return $res;
    }

    /**
     * Changes the overcurrent alert and emergency stop threshold, measured in mA.
     *
     * @param integer $newval : an integer corresponding to the overcurrent alert and emergency stop
     * threshold, measured in mA
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_overcurrent($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("overcurrent",$rest_val);
    }

    /**
     * Returns the torque regulation current when the motor is stopped, measured in mA.
     *
     * @return integer : an integer corresponding to the torque regulation current when the motor is
     * stopped, measured in mA
     *
     * On failure, throws an exception or returns Y_TCURRSTOP_INVALID.
     */
    public function get_tCurrStop()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TCURRSTOP_INVALID;
            }
        }
        $res = $this->_tCurrStop;
        return $res;
    }

    /**
     * Changes the torque regulation current when the motor is stopped, measured in mA.
     *
     * @param integer $newval : an integer corresponding to the torque regulation current when the motor
     * is stopped, measured in mA
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_tCurrStop($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("tCurrStop",$rest_val);
    }

    /**
     * Returns the torque regulation current when the motor is running, measured in mA.
     *
     * @return integer : an integer corresponding to the torque regulation current when the motor is
     * running, measured in mA
     *
     * On failure, throws an exception or returns Y_TCURRRUN_INVALID.
     */
    public function get_tCurrRun()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TCURRRUN_INVALID;
            }
        }
        $res = $this->_tCurrRun;
        return $res;
    }

    /**
     * Changes the torque regulation current when the motor is running, measured in mA.
     *
     * @param integer $newval : an integer corresponding to the torque regulation current when the motor
     * is running, measured in mA
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_tCurrRun($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("tCurrRun",$rest_val);
    }

    public function get_alertMode()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ALERTMODE_INVALID;
            }
        }
        $res = $this->_alertMode;
        return $res;
    }

    public function set_alertMode($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("alertMode",$rest_val);
    }

    public function get_auxMode()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_AUXMODE_INVALID;
            }
        }
        $res = $this->_auxMode;
        return $res;
    }

    public function set_auxMode($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("auxMode",$rest_val);
    }

    /**
     * Returns the current value of the signal generated on the auxiliary output.
     *
     * @return integer : an integer corresponding to the current value of the signal generated on the auxiliary output
     *
     * On failure, throws an exception or returns Y_AUXSIGNAL_INVALID.
     */
    public function get_auxSignal()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_AUXSIGNAL_INVALID;
            }
        }
        $res = $this->_auxSignal;
        return $res;
    }

    /**
     * Changes the value of the signal generated on the auxiliary output.
     * Acceptable values depend on the auxiliary output signal type configured.
     *
     * @param integer $newval : an integer corresponding to the value of the signal generated on the auxiliary output
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_auxSignal($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("auxSignal",$rest_val);
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
     * Retrieves a stepper motor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the stepper motor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YStepperMotor.isOnline() to test if the stepper motor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a stepper motor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the stepper motor
     *
     * @return YStepperMotor : a YStepperMotor object allowing you to drive the stepper motor.
     */
    public static function FindStepperMotor($func)
    {
        // $obj                    is a YStepperMotor;
        $obj = YFunction::_FindFromCache('StepperMotor', $func);
        if ($obj == null) {
            $obj = new YStepperMotor($func);
            YFunction::_AddToCache('StepperMotor', $func, $obj);
        }
        return $obj;
    }

    public function sendCommand($command)
    {
        // $id                     is a str;
        // $url                    is a str;
        // $retBin                 is a bin;
        // $res                    is a int;
        $id = $this->get_functionId();
        $id = substr($id,  12, 1);
        $url = sprintf('cmd.txt?%s=%s', $id, $command);
        //may throw an exception
        $retBin = $this->_download($url);
        $res = ord($retBin[0]);
        if ($res == 49) {
            if (!($res == 48)) return $this->_throw( YAPI_DEVICE_BUSY, 'Motor command pipeline is full, try again later',YAPI_DEVICE_BUSY);
        } else {
            if (!($res == 48)) return $this->_throw( YAPI_IO_ERROR, 'Motor command failed permanently',YAPI_IO_ERROR);
        }
        return YAPI_SUCCESS;
    }

    /**
     * Reinitialize the controller and clear all alert flags.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function reset()
    {
        return $this->set_command('Z');
    }

    /**
     * Starts the motor backward at the specified speed, to search for the motor home position.
     *
     * @param double $speed : desired speed, in steps per second.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function findHomePosition($speed)
    {
        return $this->sendCommand(sprintf('H%d',round(1000*$speed)));
    }

    /**
     * Starts the motor at a given speed. The time needed to reach the requested speed
     * will depend on the acceleration parameters configured for the motor.
     *
     * @param double $speed : desired speed, in steps per second. The minimal non-zero speed
     *         is 0.001 pulse per second.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function changeSpeed($speed)
    {
        return $this->sendCommand(sprintf('R%d',round(1000*$speed)));
    }

    /**
     * Starts the motor to reach a given absolute position. The time needed to reach the requested
     * position will depend on the acceleration and max speed parameters configured for
     * the motor.
     *
     * @param double $absPos : absolute position, measured in steps from the origin.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function moveTo($absPos)
    {
        return $this->sendCommand(sprintf('M%d',round(16*$absPos)));
    }

    /**
     * Starts the motor to reach a given relative position. The time needed to reach the requested
     * position will depend on the acceleration and max speed parameters configured for
     * the motor.
     *
     * @param double $relPos : relative position, measured in steps from the current position.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function moveRel($relPos)
    {
        return $this->sendCommand(sprintf('m%d',round(16*$relPos)));
    }

    /**
     * Starts the motor to reach a given relative position, keeping the speed under the
     * specified limit. The time needed to reach the requested position will depend on
     * the acceleration parameters configured for the motor.
     *
     * @param double $relPos : relative position, measured in steps from the current position.
     * @param double $maxSpeed : limit speed, in steps per second.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function moveRelSlow($relPos,$maxSpeed)
    {
        return $this->sendCommand(sprintf('m%d@%d',round(16*$relPos),round(1000*$maxSpeed)));
    }

    /**
     * Keep the motor in the same state for the specified amount of time, before processing next command.
     *
     * @param integer $waitMs : wait time, specified in milliseconds.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function pause($waitMs)
    {
        return $this->sendCommand(sprintf('_%d',$waitMs));
    }

    /**
     * Stops the motor with an emergency alert, without taking any additional precaution.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function emergencyStop()
    {
        return $this->set_command('!');
    }

    /**
     * Move one step in the direction opposite the direction set when the most recent alert was raised.
     * The move occurs even if the system is still in alert mode (end switch depressed). Caution.
     * use this function with great care as it may cause mechanical damages !
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function alertStepOut()
    {
        return $this->set_command('.');
    }

    /**
     * Move one single step in the selected direction without regards to end switches.
     * The move occurs even if the system is still in alert mode (end switch depressed). Caution.
     * use this function with great care as it may cause mechanical damages !
     *
     * @param integer $dir : Value +1 or -1, according to the desired direction of the move
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function alertStepDir($dir)
    {
        if (!($dir != 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'direction must be +1 or -1',YAPI_INVALID_ARGUMENT);
        if ($dir > 0) {
            return $this->set_command('.+');
        }
        return $this->set_command('.-');
    }

    /**
     * Stops the motor smoothly as soon as possible, without waiting for ongoing move completion.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function abortAndBrake()
    {
        return $this->set_command('B');
    }

    /**
     * Turn the controller into Hi-Z mode immediately, without waiting for ongoing move completion.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function abortAndHiZ()
    {
        return $this->set_command('z');
    }

    public function motorState()
    { return $this->get_motorState(); }

    public function diags()
    { return $this->get_diags(); }

    public function setStepPos($newval)
    { return $this->set_stepPos($newval); }

    public function stepPos()
    { return $this->get_stepPos(); }

    public function speed()
    { return $this->get_speed(); }

    public function setPullinSpeed($newval)
    { return $this->set_pullinSpeed($newval); }

    public function pullinSpeed()
    { return $this->get_pullinSpeed(); }

    public function setMaxAccel($newval)
    { return $this->set_maxAccel($newval); }

    public function maxAccel()
    { return $this->get_maxAccel(); }

    public function setMaxSpeed($newval)
    { return $this->set_maxSpeed($newval); }

    public function maxSpeed()
    { return $this->get_maxSpeed(); }

    public function stepping()
    { return $this->get_stepping(); }

    public function setStepping($newval)
    { return $this->set_stepping($newval); }

    public function overcurrent()
    { return $this->get_overcurrent(); }

    public function setOvercurrent($newval)
    { return $this->set_overcurrent($newval); }

    public function tCurrStop()
    { return $this->get_tCurrStop(); }

    public function setTCurrStop($newval)
    { return $this->set_tCurrStop($newval); }

    public function tCurrRun()
    { return $this->get_tCurrRun(); }

    public function setTCurrRun($newval)
    { return $this->set_tCurrRun($newval); }

    public function alertMode()
    { return $this->get_alertMode(); }

    public function setAlertMode($newval)
    { return $this->set_alertMode($newval); }

    public function auxMode()
    { return $this->get_auxMode(); }

    public function setAuxMode($newval)
    { return $this->set_auxMode($newval); }

    public function auxSignal()
    { return $this->get_auxSignal(); }

    public function setAuxSignal($newval)
    { return $this->set_auxSignal($newval); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of stepper motors started using yFirstStepperMotor().
     * Caution: You can't make any assumption about the returned stepper motors order.
     * If you want to find a specific a stepper motor, use StepperMotor.findStepperMotor()
     * and a hardwareID or a logical name.
     *
     * @return YStepperMotor : a pointer to a YStepperMotor object, corresponding to
     *         a stepper motor currently online, or a null pointer
     *         if there are no more stepper motors to enumerate.
     */
    public function nextStepperMotor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindStepperMotor($next_hwid);
    }

    /**
     * Starts the enumeration of stepper motors currently accessible.
     * Use the method YStepperMotor.nextStepperMotor() to iterate on
     * next stepper motors.
     *
     * @return YStepperMotor : a pointer to a YStepperMotor object, corresponding to
     *         the first stepper motor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstStepperMotor()
    {   $next_hwid = YAPI::getFirstHardwareId('StepperMotor');
        if($next_hwid == null) return null;
        return self::FindStepperMotor($next_hwid);
    }

    //--- (end of YStepperMotor implementation)

};

//--- (YStepperMotor functions)

/**
 * Retrieves a stepper motor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the stepper motor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YStepperMotor.isOnline() to test if the stepper motor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a stepper motor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the stepper motor
 *
 * @return YStepperMotor : a YStepperMotor object allowing you to drive the stepper motor.
 */
function yFindStepperMotor($func)
{
    return YStepperMotor::FindStepperMotor($func);
}

/**
 * Starts the enumeration of stepper motors currently accessible.
 * Use the method YStepperMotor.nextStepperMotor() to iterate on
 * next stepper motors.
 *
 * @return YStepperMotor : a pointer to a YStepperMotor object, corresponding to
 *         the first stepper motor currently online, or a null pointer
 *         if there are none.
 */
function yFirstStepperMotor()
{
    return YStepperMotor::FirstStepperMotor();
}

//--- (end of YStepperMotor functions)
?>