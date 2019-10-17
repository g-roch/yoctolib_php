<?php
/*********************************************************************
 *
 * $Id: yocto_serialport.php 37168 2019-09-13 17:25:10Z mvuilleu $
 *
 * Implements YSerialPort, the high-level API for SerialPort functions
 *
 * - - - - - - - - - License information: - - - - - - - - -
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

//--- (generated code: YSerialPort return codes)
//--- (end of generated code: YSerialPort return codes)
//--- (generated code: YSerialPort definitions)
if(!defined('Y_VOLTAGELEVEL_OFF'))           define('Y_VOLTAGELEVEL_OFF',          0);
if(!defined('Y_VOLTAGELEVEL_TTL3V'))         define('Y_VOLTAGELEVEL_TTL3V',        1);
if(!defined('Y_VOLTAGELEVEL_TTL3VR'))        define('Y_VOLTAGELEVEL_TTL3VR',       2);
if(!defined('Y_VOLTAGELEVEL_TTL5V'))         define('Y_VOLTAGELEVEL_TTL5V',        3);
if(!defined('Y_VOLTAGELEVEL_TTL5VR'))        define('Y_VOLTAGELEVEL_TTL5VR',       4);
if(!defined('Y_VOLTAGELEVEL_RS232'))         define('Y_VOLTAGELEVEL_RS232',        5);
if(!defined('Y_VOLTAGELEVEL_RS485'))         define('Y_VOLTAGELEVEL_RS485',        6);
if(!defined('Y_VOLTAGELEVEL_TTL1V8'))        define('Y_VOLTAGELEVEL_TTL1V8',       7);
if(!defined('Y_VOLTAGELEVEL_INVALID'))       define('Y_VOLTAGELEVEL_INVALID',      -1);
if(!defined('Y_RXCOUNT_INVALID'))            define('Y_RXCOUNT_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_TXCOUNT_INVALID'))            define('Y_TXCOUNT_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_ERRCOUNT_INVALID'))           define('Y_ERRCOUNT_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_RXMSGCOUNT_INVALID'))         define('Y_RXMSGCOUNT_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_TXMSGCOUNT_INVALID'))         define('Y_TXMSGCOUNT_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_LASTMSG_INVALID'))            define('Y_LASTMSG_INVALID',           YAPI_INVALID_STRING);
if(!defined('Y_CURRENTJOB_INVALID'))         define('Y_CURRENTJOB_INVALID',        YAPI_INVALID_STRING);
if(!defined('Y_STARTUPJOB_INVALID'))         define('Y_STARTUPJOB_INVALID',        YAPI_INVALID_STRING);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
if(!defined('Y_PROTOCOL_INVALID'))           define('Y_PROTOCOL_INVALID',          YAPI_INVALID_STRING);
if(!defined('Y_SERIALMODE_INVALID'))         define('Y_SERIALMODE_INVALID',        YAPI_INVALID_STRING);
//--- (end of generated code: YSerialPort definitions)


//--- (generated code: YSnoopingRecord definitions)
//--- (end of generated code: YSnoopingRecord definitions)

//--- (generated code: YSnoopingRecord declaration)
/**
 * YSnoopingRecord Class: Description of a message intercepted
 *
 *
 */
class YSnoopingRecord
{
    //--- (end of generated code: YSnoopingRecord declaration)

    //--- (generated code: YSnoopingRecord attributes)
    protected $_tim                      = 0;                            // int
    protected $_dir                      = 0;                            // int
    protected $_msg                      = "";                           // str
    //--- (end of generated code: YSnoopingRecord attributes)

    function __construct($str_json)
    {
        //--- (generated code: YSnoopingRecord constructor)
        //--- (end of generated code: YSnoopingRecord constructor)

        $loadval = json_decode($str_json, TRUE);
        $this->_tim = $loadval['t'];
        $this->_dir = $loadval['m'][0] == '<' ? 1 : 0;
        $this->_msg = substr($loadval['m'], 1);
    }

    //--- (generated code: YSnoopingRecord implementation)

    public function get_time()
    {
        return $this->_tim;
    }

    public function get_direction()
    {
        return $this->_dir;
    }

    public function get_message()
    {
        return $this->_msg;
    }

    //--- (end of generated code: YSnoopingRecord implementation)
}


//--- (generated code: YSerialPort declaration)
/**
 * YSerialPort Class: SerialPort function interface
 *
 * The SerialPort function interface allows you to fully drive a Yoctopuce
 * serial port, to send and receive data, and to configure communication
 * parameters (baud rate, bit count, parity, flow control and protocol).
 * Note that Yoctopuce serial ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YSerialPort extends YFunction
{
    const RXCOUNT_INVALID                = YAPI_INVALID_UINT;
    const TXCOUNT_INVALID                = YAPI_INVALID_UINT;
    const ERRCOUNT_INVALID               = YAPI_INVALID_UINT;
    const RXMSGCOUNT_INVALID             = YAPI_INVALID_UINT;
    const TXMSGCOUNT_INVALID             = YAPI_INVALID_UINT;
    const LASTMSG_INVALID                = YAPI_INVALID_STRING;
    const CURRENTJOB_INVALID             = YAPI_INVALID_STRING;
    const STARTUPJOB_INVALID             = YAPI_INVALID_STRING;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    const PROTOCOL_INVALID               = YAPI_INVALID_STRING;
    const VOLTAGELEVEL_OFF               = 0;
    const VOLTAGELEVEL_TTL3V             = 1;
    const VOLTAGELEVEL_TTL3VR            = 2;
    const VOLTAGELEVEL_TTL5V             = 3;
    const VOLTAGELEVEL_TTL5VR            = 4;
    const VOLTAGELEVEL_RS232             = 5;
    const VOLTAGELEVEL_RS485             = 6;
    const VOLTAGELEVEL_TTL1V8            = 7;
    const VOLTAGELEVEL_INVALID           = -1;
    const SERIALMODE_INVALID             = YAPI_INVALID_STRING;
    //--- (end of generated code: YSerialPort declaration)

    //--- (generated code: YSerialPort attributes)
    protected $_rxCount                  = Y_RXCOUNT_INVALID;            // UInt31
    protected $_txCount                  = Y_TXCOUNT_INVALID;            // UInt31
    protected $_errCount                 = Y_ERRCOUNT_INVALID;           // UInt31
    protected $_rxMsgCount               = Y_RXMSGCOUNT_INVALID;         // UInt31
    protected $_txMsgCount               = Y_TXMSGCOUNT_INVALID;         // UInt31
    protected $_lastMsg                  = Y_LASTMSG_INVALID;            // Text
    protected $_currentJob               = Y_CURRENTJOB_INVALID;         // Text
    protected $_startupJob               = Y_STARTUPJOB_INVALID;         // Text
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    protected $_protocol                 = Y_PROTOCOL_INVALID;           // Protocol
    protected $_voltageLevel             = Y_VOLTAGELEVEL_INVALID;       // SerialVoltageLevel
    protected $_serialMode               = Y_SERIALMODE_INVALID;         // SerialMode
    protected $_rxptr                    = 0;                            // int
    protected $_rxbuff                   = "";                           // bin
    protected $_rxbuffptr                = 0;                            // int
    //--- (end of generated code: YSerialPort attributes)

    function __construct($str_func)
    {
        //--- (generated code: YSerialPort constructor)
        parent::__construct($str_func);
        $this->_className = 'SerialPort';

        //--- (end of generated code: YSerialPort constructor)
    }

    //--- (generated code: YSerialPort implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'rxCount':
            $this->_rxCount = intval($val);
            return 1;
        case 'txCount':
            $this->_txCount = intval($val);
            return 1;
        case 'errCount':
            $this->_errCount = intval($val);
            return 1;
        case 'rxMsgCount':
            $this->_rxMsgCount = intval($val);
            return 1;
        case 'txMsgCount':
            $this->_txMsgCount = intval($val);
            return 1;
        case 'lastMsg':
            $this->_lastMsg = $val;
            return 1;
        case 'currentJob':
            $this->_currentJob = $val;
            return 1;
        case 'startupJob':
            $this->_startupJob = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        case 'protocol':
            $this->_protocol = $val;
            return 1;
        case 'voltageLevel':
            $this->_voltageLevel = intval($val);
            return 1;
        case 'serialMode':
            $this->_serialMode = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the total number of bytes received since last reset.
     *
     * @return integer : an integer corresponding to the total number of bytes received since last reset
     *
     * On failure, throws an exception or returns Y_RXCOUNT_INVALID.
     */
    public function get_rxCount()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_RXCOUNT_INVALID;
            }
        }
        $res = $this->_rxCount;
        return $res;
    }

    /**
     * Returns the total number of bytes transmitted since last reset.
     *
     * @return integer : an integer corresponding to the total number of bytes transmitted since last reset
     *
     * On failure, throws an exception or returns Y_TXCOUNT_INVALID.
     */
    public function get_txCount()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TXCOUNT_INVALID;
            }
        }
        $res = $this->_txCount;
        return $res;
    }

    /**
     * Returns the total number of communication errors detected since last reset.
     *
     * @return integer : an integer corresponding to the total number of communication errors detected since last reset
     *
     * On failure, throws an exception or returns Y_ERRCOUNT_INVALID.
     */
    public function get_errCount()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ERRCOUNT_INVALID;
            }
        }
        $res = $this->_errCount;
        return $res;
    }

    /**
     * Returns the total number of messages received since last reset.
     *
     * @return integer : an integer corresponding to the total number of messages received since last reset
     *
     * On failure, throws an exception or returns Y_RXMSGCOUNT_INVALID.
     */
    public function get_rxMsgCount()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_RXMSGCOUNT_INVALID;
            }
        }
        $res = $this->_rxMsgCount;
        return $res;
    }

    /**
     * Returns the total number of messages send since last reset.
     *
     * @return integer : an integer corresponding to the total number of messages send since last reset
     *
     * On failure, throws an exception or returns Y_TXMSGCOUNT_INVALID.
     */
    public function get_txMsgCount()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TXMSGCOUNT_INVALID;
            }
        }
        $res = $this->_txMsgCount;
        return $res;
    }

    /**
     * Returns the latest message fully received (for Line, Frame and Modbus protocols).
     *
     * @return string : a string corresponding to the latest message fully received (for Line, Frame and
     * Modbus protocols)
     *
     * On failure, throws an exception or returns Y_LASTMSG_INVALID.
     */
    public function get_lastMsg()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_LASTMSG_INVALID;
            }
        }
        $res = $this->_lastMsg;
        return $res;
    }

    /**
     * Returns the name of the job file currently in use.
     *
     * @return string : a string corresponding to the name of the job file currently in use
     *
     * On failure, throws an exception or returns Y_CURRENTJOB_INVALID.
     */
    public function get_currentJob()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CURRENTJOB_INVALID;
            }
        }
        $res = $this->_currentJob;
        return $res;
    }

    /**
     * Selects a job file to run immediately. If an empty string is
     * given as argument, stops running current job file.
     *
     * @param string $newval : a string
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentJob($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("currentJob",$rest_val);
    }

    /**
     * Returns the job file to use when the device is powered on.
     *
     * @return string : a string corresponding to the job file to use when the device is powered on
     *
     * On failure, throws an exception or returns Y_STARTUPJOB_INVALID.
     */
    public function get_startupJob()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_STARTUPJOB_INVALID;
            }
        }
        $res = $this->_startupJob;
        return $res;
    }

    /**
     * Changes the job to use when the device is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the job to use when the device is powered on
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_startupJob($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("startupJob",$rest_val);
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
     * Returns the type of protocol used over the serial line, as a string.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Modbus-ASCII" for MODBUS messages in ASCII mode,
     * "Modbus-RTU" for MODBUS messages in RTU mode,
     * "Wiegand-ASCII" for Wiegand messages in ASCII mode,
     * "Wiegand-26","Wiegand-34", etc for Wiegand messages in byte mode,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     *
     * @return string : a string corresponding to the type of protocol used over the serial line, as a string
     *
     * On failure, throws an exception or returns Y_PROTOCOL_INVALID.
     */
    public function get_protocol()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_PROTOCOL_INVALID;
            }
        }
        $res = $this->_protocol;
        return $res;
    }

    /**
     * Changes the type of protocol used over the serial line.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Modbus-ASCII" for MODBUS messages in ASCII mode,
     * "Modbus-RTU" for MODBUS messages in RTU mode,
     * "Wiegand-ASCII" for Wiegand messages in ASCII mode,
     * "Wiegand-26","Wiegand-34", etc for Wiegand messages in byte mode,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     * The suffix "/[wait]ms" can be added to reduce the transmit rate so that there
     * is always at lest the specified number of milliseconds between each bytes sent.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the type of protocol used over the serial line
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_protocol($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("protocol",$rest_val);
    }

    /**
     * Returns the voltage level used on the serial line.
     *
     * @return integer : a value among Y_VOLTAGELEVEL_OFF, Y_VOLTAGELEVEL_TTL3V, Y_VOLTAGELEVEL_TTL3VR,
     * Y_VOLTAGELEVEL_TTL5V, Y_VOLTAGELEVEL_TTL5VR, Y_VOLTAGELEVEL_RS232, Y_VOLTAGELEVEL_RS485 and
     * Y_VOLTAGELEVEL_TTL1V8 corresponding to the voltage level used on the serial line
     *
     * On failure, throws an exception or returns Y_VOLTAGELEVEL_INVALID.
     */
    public function get_voltageLevel()
    {
        // $res                    is a enumSERIALVOLTAGELEVEL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_VOLTAGELEVEL_INVALID;
            }
        }
        $res = $this->_voltageLevel;
        return $res;
    }

    /**
     * Changes the voltage type used on the serial line. Valid
     * values  will depend on the Yoctopuce device model featuring
     * the serial port feature.  Check your device documentation
     * to find out which values are valid for that specific model.
     * Trying to set an invalid value will have no effect.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param integer $newval : a value among Y_VOLTAGELEVEL_OFF, Y_VOLTAGELEVEL_TTL3V,
     * Y_VOLTAGELEVEL_TTL3VR, Y_VOLTAGELEVEL_TTL5V, Y_VOLTAGELEVEL_TTL5VR, Y_VOLTAGELEVEL_RS232,
     * Y_VOLTAGELEVEL_RS485 and Y_VOLTAGELEVEL_TTL1V8 corresponding to the voltage type used on the serial line
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltageLevel($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltageLevel",$rest_val);
    }

    /**
     * Returns the serial port communication parameters, as a string such as
     * "9600,8N1". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. An optional suffix is included
     * if flow control is active: "CtsRts" for hardware handshake, "XOnXOff"
     * for logical flow control and "Simplex" for acquiring a shared bus using
     * the RTS line (as used by some RS485 adapters for instance).
     *
     * @return string : a string corresponding to the serial port communication parameters, as a string such as
     *         "9600,8N1"
     *
     * On failure, throws an exception or returns Y_SERIALMODE_INVALID.
     */
    public function get_serialMode()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_SERIALMODE_INVALID;
            }
        }
        $res = $this->_serialMode;
        return $res;
    }

    /**
     * Changes the serial port communication parameters, with a string such as
     * "9600,8N1". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. An optional suffix can be added
     * to enable flow control: "CtsRts" for hardware handshake, "XOnXOff"
     * for logical flow control and "Simplex" for acquiring a shared bus using
     * the RTS line (as used by some RS485 adapters for instance).
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the serial port communication parameters, with a
     * string such as
     *         "9600,8N1"
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_serialMode($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("serialMode",$rest_val);
    }

    /**
     * Retrieves a serial port for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the serial port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YSerialPort.isOnline() to test if the serial port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a serial port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the serial port
     *
     * @return YSerialPort : a YSerialPort object allowing you to drive the serial port.
     */
    public static function FindSerialPort($func)
    {
        // $obj                    is a YSerialPort;
        $obj = YFunction::_FindFromCache('SerialPort', $func);
        if ($obj == null) {
            $obj = new YSerialPort($func);
            YFunction::_AddToCache('SerialPort', $func, $obj);
        }
        return $obj;
    }

    public function sendCommand($text)
    {
        return $this->set_command($text);
    }

    /**
     * Reads a single line (or message) from the receive buffer, starting at current stream position.
     * This function is intended to be used when the serial port is configured for a message protocol,
     * such as 'Line' mode or frame protocols.
     *
     * If data at current stream position is not available anymore in the receive buffer,
     * the function returns the oldest available line and moves the stream position just after.
     * If no new full line is received, the function returns an empty line.
     *
     * @return string : a string with a single line of text
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function readLine()
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        // $res                    is a str;

        $url = sprintf('rxmsg.json?pos=%d&len=1&maxw=1', $this->_rxptr);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Searches for incoming messages in the serial port receive buffer matching a given pattern,
     * starting at current position. This function will only compare and return printable characters
     * in the message strings. Binary protocols are handled as hexadecimal strings.
     *
     * The search returns all messages matching the expression provided as argument in the buffer.
     * If no matching message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param string $pattern : a limited regular expression describing the expected message format,
     *         or an empty string if all messages should be returned (no filtering).
     *         When using binary protocols, the format applies to the hexadecimal
     *         representation of the message.
     * @param integer $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return string[] : an array of strings containing the messages found, if any.
     *         Binary messages are converted to hexadecimal representation.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function readMessages($pattern,$maxWait)
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        $res = Array();         // strArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&pat=%s', $this->_rxptr, $maxWait, $pattern);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = $this->_json_get_string($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Changes the current internal stream position to the specified value. This function
     * does not affect the device, it only changes the value stored in the API object
     * for the next read operations.
     *
     * @param integer $absPos : the absolute position index for next read operations.
     *
     * @return integer : nothing.
     */
    public function read_seek($absPos)
    {
        $this->_rxptr = $absPos;
        return YAPI_SUCCESS;
    }

    /**
     * Returns the current absolute stream position pointer of the API object.
     *
     * @return integer : the absolute position index for next read operations.
     */
    public function read_tell()
    {
        return $this->_rxptr;
    }

    /**
     * Returns the number of bytes available to read in the input buffer starting from the
     * current absolute stream position pointer of the API object.
     *
     * @return integer : the number of bytes available to read
     */
    public function read_avail()
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $res                    is a int;

        $buff = $this->_download(sprintf('rxcnt.bin?pos=%d', $this->_rxptr));
        $bufflen = strlen($buff) - 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $bufflen = $bufflen - 1;
        }
        $res = intVal(substr($buff,  0, $bufflen));
        return $res;
    }

    /**
     * Sends a text line query to the serial port, and reads the reply, if any.
     * This function is intended to be used when the serial port is configured for 'Line' protocol.
     *
     * @param string $query : the line query to send (without CR/LF)
     * @param integer $maxWait : the maximum number of milliseconds to wait for a reply.
     *
     * @return string : the next text line received after sending the text query, as a string.
     *         Additional lines can be obtained by calling readLine or readMessages.
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function queryLine($query,$maxWait)
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        // $res                    is a str;

        $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=!%s', $maxWait, $this->_escapeAttr($query));
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Saves the job definition string (JSON data) into a job file.
     * The job file can be later enabled using selectJob().
     *
     * @param string $jobfile : name of the job file to save on the device filesystem
     * @param string $jsonDef : a string containing a JSON definition of the job
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function uploadJob($jobfile,$jsonDef)
    {
        $this->_upload($jobfile, $jsonDef);
        return YAPI_SUCCESS;
    }

    /**
     * Load and start processing the specified job file. The file must have
     * been previously created using the user interface or uploaded on the
     * device filesystem using the uploadJob() function.
     *
     * @param string $jobfile : name of the job file (on the device filesystem)
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectJob($jobfile)
    {
        return $this->set_currentJob($jobfile);
    }

    /**
     * Clears the serial port buffer and resets counters to zero.
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function reset()
    {
        $this->_rxptr = 0;
        $this->_rxbuffptr = 0;
        $this->_rxbuff = '';

        return $this->sendCommand('Z');
    }

    /**
     * Sends a single byte to the serial port.
     *
     * @param integer $code : the byte to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeByte($code)
    {
        return $this->sendCommand(sprintf('$%02X', $code));
    }

    /**
     * Sends an ASCII string to the serial port, as is.
     *
     * @param string $text : the text string to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeStr($text)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = $text;
        $bufflen = strlen($buff);
        if ($bufflen < 100) {
            // if string is pure text, we can send it as a simple command (faster)
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = ord($buff[$idx]);
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('+%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a binary buffer to the serial port, as is.
     *
     * @param string $buff : the binary buffer to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeBin($buff)
    {
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a byte sequence (provided as a list of bytes) to the serial port.
     *
     * @param Integer[] $byteList : a list of byte codes
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeArray($byteList)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = sizeof($byteList);
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = $byteList[$idx];
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends a byte sequence (provided as a hexadecimal string) to the serial port.
     *
     * @param string $hexString : a string of hexadecimal byte codes
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeHex($hexString)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('$%s',$hexString));
        }
        $bufflen = (($bufflen) >> (1));
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = hexdec(substr($hexString,  2 * $idx, 2));
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends an ASCII string to the serial port, followed by a line break (CR LF).
     *
     * @param string $text : the text string to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeLine($text)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = sprintf('%s'."\r".''."\n".'', $text);
        $bufflen = strlen($buff)-2;
        if ($bufflen < 100) {
            // if string is pure text, we can send it as a simple command (faster)
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = ord($buff[$idx]);
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('!%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Reads one byte from the receive buffer, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer,
     * or if there is no data available yet, the function returns YAPI_NO_MORE_DATA.
     *
     * @return integer : the next byte
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function readByte()
    {
        // $currpos                is a int;
        // $reqlen                 is a int;
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $res                    is a int;
        // first check if we have the requested character in the look-ahead buffer
        $bufflen = strlen($this->_rxbuff);
        if (($this->_rxptr >= $this->_rxbuffptr) && ($this->_rxptr < $this->_rxbuffptr+$bufflen)) {
            $res = ord($this->_rxbuff[$this->_rxptr-$this->_rxbuffptr]);
            $this->_rxptr = $this->_rxptr + 1;
            return $res;
        }
        // try to preload more than one byte to speed-up byte-per-byte access
        $currpos = $this->_rxptr;
        $reqlen = 1024;
        $buff = $this->readBin($reqlen);
        $bufflen = strlen($buff);
        if ($this->_rxptr == $currpos+$bufflen) {
            $res = ord($buff[0]);
            $this->_rxptr = $currpos+1;
            $this->_rxbuffptr = $currpos;
            $this->_rxbuff = $buff;
            return $res;
        }
        // mixed bidirectional data, retry with a smaller block
        $this->_rxptr = $currpos;
        $reqlen = 16;
        $buff = $this->readBin($reqlen);
        $bufflen = strlen($buff);
        if ($this->_rxptr == $currpos+$bufflen) {
            $res = ord($buff[0]);
            $this->_rxptr = $currpos+1;
            $this->_rxbuffptr = $currpos;
            $this->_rxbuff = $buff;
            return $res;
        }
        // still mixed, need to process character by character
        $this->_rxptr = $currpos;

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=1', $this->_rxptr));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        if ($bufflen == 0) {
            return YAPI_NO_MORE_DATA;
        }
        $res = ord($buff[0]);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param integer $nChars : the maximum number of characters to read
     *
     * @return string : a string with receive buffer contents
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function readStr($nChars)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $res                    is a str;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = substr($buff,  0, $bufflen);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a binary buffer, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param integer $nChars : the maximum number of bytes to read
     *
     * @return string : a binary object with receive buffer contents
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function readBin($nChars)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $idx                    is a int;
        // $res                    is a bin;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $res[$idx] = pack('C', ord($buff[$idx]));
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from the receive buffer as a list of bytes, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param integer $nChars : the maximum number of bytes to read
     *
     * @return Integer[] : a sequence of bytes with receive buffer contents
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function readArray($nChars)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $idx                    is a int;
        // $b                      is a int;
        $res = Array();         // intArr;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        while(sizeof($res) > 0) { array_pop($res); };
        $idx = 0;
        while ($idx < $bufflen) {
            $b = ord($buff[$idx]);
            $res[] = $b;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from the receive buffer as a hexadecimal string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param integer $nBytes : the maximum number of bytes to read
     *
     * @return string : a string with receive buffer contents, encoded in hexadecimal
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function readHex($nBytes)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $ofs                    is a int;
        // $res                    is a str;
        if ($nBytes > 65535) {
            $nBytes = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nBytes));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = '';
        $ofs = 0;
        while ($ofs + 3 < $bufflen) {
            $res = sprintf('%s%02X%02X%02X%02X', $res, ord($buff[$ofs]), ord($buff[$ofs + 1]), ord($buff[$ofs + 2]), ord($buff[$ofs + 3]));
            $ofs = $ofs + 4;
        }
        while ($ofs < $bufflen) {
            $res = sprintf('%s%02X', $res, ord($buff[$ofs]));
            $ofs = $ofs + 1;
        }
        return $res;
    }

    /**
     * Manually sets the state of the RTS line. This function has no effect when
     * hardware handshake is enabled, as the RTS line is driven automatically.
     *
     * @param integer $val : 1 to turn RTS on, 0 to turn RTS off
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_RTS($val)
    {
        return $this->sendCommand(sprintf('R%d',$val));
    }

    /**
     * Reads the level of the CTS line. The CTS line is usually driven by
     * the RTS signal of the connected serial device.
     *
     * @return integer : 1 if the CTS line is high, 0 if the CTS line is low.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_CTS()
    {
        // $buff                   is a bin;
        // $res                    is a int;

        $buff = $this->_download('cts.txt');
        if (!(strlen($buff) == 1)) return $this->_throw( YAPI_IO_ERROR, 'invalid CTS reply',YAPI_IO_ERROR);
        $res = ord($buff[0]) - 48;
        return $res;
    }

    /**
     * Retrieves messages (both direction) in the serial port buffer, starting at current position.
     * This function will only compare and return printable characters in the message strings.
     * Binary protocols are handled as hexadecimal strings.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param integer $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return YSnoopingRecord[] : an array of YSnoopingRecord objects containing the messages found, if any.
     *         Binary messages are converted to hexadecimal representation.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function snoopMessages($maxWait)
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        $res = Array();         // YSnoopingRecordArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&t=0', $this->_rxptr, $maxWait);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = new YSnoopingRecord($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Sends a MODBUS message (provided as a hexadecimal string) to the serial port.
     * The message must start with the slave address. The MODBUS CRC/LRC is
     * automatically added by the function. This function does not wait for a reply.
     *
     * @param string $hexString : a hexadecimal message string, including device address but no CRC/LRC
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeMODBUS($hexString)
    {
        return $this->sendCommand(sprintf(':%s',$hexString));
    }

    /**
     * Sends a message to a specified MODBUS slave connected to the serial port, and reads the
     * reply, if any. The message is the PDU, provided as a vector of bytes.
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to query
     * @param Integer[] $pduBytes : the message to send (PDU), as a vector of bytes. The first byte of the
     *         PDU is the MODBUS function code.
     *
     * @return Integer[] : the received reply, as a vector of bytes.
     *
     * On failure, throws an exception or returns an empty array (or a MODBUS error reply).
     */
    public function queryMODBUS($slaveNo,$pduBytes)
    {
        // $funCode                is a int;
        // $nib                    is a int;
        // $i                      is a int;
        // $cmd                    is a str;
        // $url                    is a str;
        // $pat                    is a str;
        // $msgs                   is a bin;
        $reps = Array();        // strArr;
        // $rep                    is a str;
        $res = Array();         // intArr;
        // $replen                 is a int;
        // $hexb                   is a int;
        $funCode = $pduBytes[0];
        $nib = (($funCode) >> (4));
        $pat = sprintf('%02X[%X%X]%X.*', $slaveNo, $nib, ($nib+8), (($funCode) & (15)));
        $cmd = sprintf('%02X%02X', $slaveNo, $funCode);
        $i = 1;
        while ($i < sizeof($pduBytes)) {
            $cmd = sprintf('%s%02X', $cmd, (($pduBytes[$i]) & (0xff)));
            $i = $i + 1;
        }

        $url = sprintf('rxmsg.json?cmd=:%s&pat=:%s', $cmd, $pat);
        $msgs = $this->_download($url);
        $reps = $this->_json_get_array($msgs);
        if (!(sizeof($reps) > 1)) return $this->_throw( YAPI_IO_ERROR, 'no reply from MODBUS slave',$res);
        if (sizeof($reps) > 1) {
            $rep = $this->_json_get_string($reps[0]);
            $replen = ((strlen($rep) - 3) >> (1));
            $i = 0;
            while ($i < $replen) {
                $hexb = hexdec(substr($rep, 2 * $i + 3, 2));
                $res[] = $hexb;
                $i = $i + 1;
            }
            if ($res[0] != $funCode) {
                $i = $res[1];
                if (!($i > 1)) return $this->_throw( YAPI_NOT_SUPPORTED, 'MODBUS error: unsupported function code',$res);
                if (!($i > 2)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'MODBUS error: illegal data address',$res);
                if (!($i > 3)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'MODBUS error: illegal data value',$res);
                if (!($i > 4)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'MODBUS error: failed to execute function',$res);
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous internal bits (or coil status) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x01 (Read Coils).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to query
     * @param integer $pduAddr : the relative address of the first bit/coil to read (zero-based)
     * @param integer $nBits : the number of bits/coils to read
     *
     * @return Integer[] : a vector of integers, each corresponding to one bit.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadBits($slaveNo,$pduAddr,$nBits)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $bitpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu[] = 0x01;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $bitpos = 0;
        $idx = 2;
        $val = $reply[$idx];
        $mask = 1;
        while ($bitpos < $nBits) {
            if ((($val) & ($mask)) == 0) {
                $res[] = 0;
            } else {
                $res[] = 1;
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $idx = $idx + 1;
                $val = $reply[$idx];
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous input bits (or discrete inputs) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x02 (Read Discrete Inputs).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to query
     * @param integer $pduAddr : the relative address of the first bit/input to read (zero-based)
     * @param integer $nBits : the number of bits/inputs to read
     *
     * @return Integer[] : a vector of integers, each corresponding to one bit.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadInputBits($slaveNo,$pduAddr,$nBits)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $bitpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu[] = 0x02;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $bitpos = 0;
        $idx = 2;
        $val = $reply[$idx];
        $mask = 1;
        while ($bitpos < $nBits) {
            if ((($val) & ($mask)) == 0) {
                $res[] = 0;
            } else {
                $res[] = 1;
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $idx = $idx + 1;
                $val = $reply[$idx];
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous internal registers (holding registers) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x03 (Read Holding Registers).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to query
     * @param integer $pduAddr : the relative address of the first holding register to read (zero-based)
     * @param integer $nWords : the number of holding registers to read
     *
     * @return Integer[] : a vector of integers, each corresponding to one 16-bit register value.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadRegisters($slaveNo,$pduAddr,$nWords)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $regpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        $pdu[] = 0x03;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    /**
     * Reads one or more contiguous input registers (read-only registers) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x04 (Read Input Registers).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to query
     * @param integer $pduAddr : the relative address of the first input register to read (zero-based)
     * @param integer $nWords : the number of input registers to read
     *
     * @return Integer[] : a vector of integers, each corresponding to one 16-bit input value.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadInputRegisters($slaveNo,$pduAddr,$nWords)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $regpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        $pdu[] = 0x04;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    /**
     * Sets a single internal bit (or coil) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x05 (Write Single Coil).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to drive
     * @param integer $pduAddr : the relative address of the bit/coil to set (zero-based)
     * @param integer $value : the value to set (0 for OFF state, non-zero for ON state)
     *
     * @return integer : the number of bits/coils affected on the device (1)
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteBit($slaveNo,$pduAddr,$value)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        if ($value != 0) {
            $value = 0xff;
        }
        $pdu[] = 0x05;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = $value;
        $pdu[] = 0x00;

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = 1;
        return $res;
    }

    /**
     * Sets several contiguous internal bits (or coils) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x0f (Write Multiple Coils).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to drive
     * @param integer $pduAddr : the relative address of the first bit/coil to set (zero-based)
     * @param Integer[] $bits : the vector of bits to be set (one integer per bit)
     *
     * @return integer : the number of bits/coils affected on the device
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteBits($slaveNo,$pduAddr,$bits)
    {
        // $nBits                  is a int;
        // $nBytes                 is a int;
        // $bitpos                 is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        $nBits = sizeof($bits);
        $nBytes = ((($nBits + 7)) >> (3));
        $pdu[] = 0x0f;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));
        $pdu[] = $nBytes;
        $bitpos = 0;
        $val = 0;
        $mask = 1;
        while ($bitpos < $nBits) {
            if ($bits[$bitpos] != 0) {
                $val = (($val) | ($mask));
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $pdu[] = $val;
                $val = 0;
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        if ($mask != 1) {
            $pdu[] = $val;
        }

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = (($reply[3]) << (8));
        $res = $res + $reply[4];
        return $res;
    }

    /**
     * Sets a single internal register (or holding register) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x06 (Write Single Register).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to drive
     * @param integer $pduAddr : the relative address of the register to set (zero-based)
     * @param integer $value : the 16 bit value to set
     *
     * @return integer : the number of registers affected on the device (1)
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteRegister($slaveNo,$pduAddr,$value)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        $pdu[] = 0x06;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($value) >> (8));
        $pdu[] = (($value) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = 1;
        return $res;
    }

    /**
     * Sets several contiguous internal registers (or holding registers) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x10 (Write Multiple Registers).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to drive
     * @param integer $pduAddr : the relative address of the first internal register to set (zero-based)
     * @param Integer[] $values : the vector of 16 bit values to set
     *
     * @return integer : the number of registers affected on the device
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteRegisters($slaveNo,$pduAddr,$values)
    {
        // $nWords                 is a int;
        // $nBytes                 is a int;
        // $regpos                 is a int;
        // $val                    is a int;
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        $nWords = sizeof($values);
        $nBytes = 2 * $nWords;
        $pdu[] = 0x10;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));
        $pdu[] = $nBytes;
        $regpos = 0;
        while ($regpos < $nWords) {
            $val = $values[$regpos];
            $pdu[] = (($val) >> (8));
            $pdu[] = (($val) & (0xff));
            $regpos = $regpos + 1;
        }

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = (($reply[3]) << (8));
        $res = $res + $reply[4];
        return $res;
    }

    /**
     * Sets several contiguous internal registers (holding registers) on a MODBUS serial device,
     * then performs a contiguous read of a set of (possibly different) internal registers.
     * This method uses the MODBUS function code 0x17 (Read/Write Multiple Registers).
     *
     * @param integer $slaveNo : the address of the slave MODBUS device to drive
     * @param integer $pduWriteAddr : the relative address of the first internal register to set (zero-based)
     * @param Integer[] $values : the vector of 16 bit values to set
     * @param integer $pduReadAddr : the relative address of the first internal register to read (zero-based)
     * @param integer $nReadWords : the number of 16 bit values to read
     *
     * @return Integer[] : a vector of integers, each corresponding to one 16-bit register value read.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusWriteAndReadRegisters($slaveNo,$pduWriteAddr,$values,$pduReadAddr,$nReadWords)
    {
        // $nWriteWords            is a int;
        // $nBytes                 is a int;
        // $regpos                 is a int;
        // $val                    is a int;
        // $idx                    is a int;
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        $nWriteWords = sizeof($values);
        $nBytes = 2 * $nWriteWords;
        $pdu[] = 0x17;
        $pdu[] = (($pduReadAddr) >> (8));
        $pdu[] = (($pduReadAddr) & (0xff));
        $pdu[] = (($nReadWords) >> (8));
        $pdu[] = (($nReadWords) & (0xff));
        $pdu[] = (($pduWriteAddr) >> (8));
        $pdu[] = (($pduWriteAddr) & (0xff));
        $pdu[] = (($nWriteWords) >> (8));
        $pdu[] = (($nWriteWords) & (0xff));
        $pdu[] = $nBytes;
        $regpos = 0;
        while ($regpos < $nWriteWords) {
            $val = $values[$regpos];
            $pdu[] = (($val) >> (8));
            $pdu[] = (($val) & (0xff));
            $regpos = $regpos + 1;
        }

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nReadWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    public function rxCount()
    { return $this->get_rxCount(); }

    public function txCount()
    { return $this->get_txCount(); }

    public function errCount()
    { return $this->get_errCount(); }

    public function rxMsgCount()
    { return $this->get_rxMsgCount(); }

    public function txMsgCount()
    { return $this->get_txMsgCount(); }

    public function lastMsg()
    { return $this->get_lastMsg(); }

    public function currentJob()
    { return $this->get_currentJob(); }

    public function setCurrentJob($newval)
    { return $this->set_currentJob($newval); }

    public function startupJob()
    { return $this->get_startupJob(); }

    public function setStartupJob($newval)
    { return $this->set_startupJob($newval); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    public function protocol()
    { return $this->get_protocol(); }

    public function setProtocol($newval)
    { return $this->set_protocol($newval); }

    public function voltageLevel()
    { return $this->get_voltageLevel(); }

    public function setVoltageLevel($newval)
    { return $this->set_voltageLevel($newval); }

    public function serialMode()
    { return $this->get_serialMode(); }

    public function setSerialMode($newval)
    { return $this->set_serialMode($newval); }

    /**
     * Continues the enumeration of serial ports started using yFirstSerialPort().
     * Caution: You can't make any assumption about the returned serial ports order.
     * If you want to find a specific a serial port, use SerialPort.findSerialPort()
     * and a hardwareID or a logical name.
     *
     * @return YSerialPort : a pointer to a YSerialPort object, corresponding to
     *         a serial port currently online, or a null pointer
     *         if there are no more serial ports to enumerate.
     */
    public function nextSerialPort()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindSerialPort($next_hwid);
    }

    /**
     * Starts the enumeration of serial ports currently accessible.
     * Use the method YSerialPort.nextSerialPort() to iterate on
     * next serial ports.
     *
     * @return YSerialPort : a pointer to a YSerialPort object, corresponding to
     *         the first serial port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSerialPort()
    {   $next_hwid = YAPI::getFirstHardwareId('SerialPort');
        if($next_hwid == null) return null;
        return self::FindSerialPort($next_hwid);
    }

    //--- (end of generated code: YSerialPort implementation)

};

//--- (generated code: YSerialPort functions)

/**
 * Retrieves a serial port for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the serial port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YSerialPort.isOnline() to test if the serial port is
 * indeed online at a given time. In case of ambiguity when looking for
 * a serial port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the serial port
 *
 * @return YSerialPort : a YSerialPort object allowing you to drive the serial port.
 */
function yFindSerialPort($func)
{
    return YSerialPort::FindSerialPort($func);
}

/**
 * Starts the enumeration of serial ports currently accessible.
 * Use the method YSerialPort.nextSerialPort() to iterate on
 * next serial ports.
 *
 * @return YSerialPort : a pointer to a YSerialPort object, corresponding to
 *         the first serial port currently online, or a null pointer
 *         if there are none.
 */
function yFirstSerialPort()
{
    return YSerialPort::FirstSerialPort();
}

//--- (end of generated code: YSerialPort functions)
?>