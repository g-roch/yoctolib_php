<?php
/*********************************************************************
 *
 *  $Id: yocto_i2cport.php 37168 2019-09-13 17:25:10Z mvuilleu $
 *
 *  Implements YI2cPort, the high-level API for I2cPort functions
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

//--- (YI2cPort return codes)
//--- (end of YI2cPort return codes)
//--- (YI2cPort definitions)
if(!defined('Y_I2CVOLTAGELEVEL_OFF'))        define('Y_I2CVOLTAGELEVEL_OFF',       0);
if(!defined('Y_I2CVOLTAGELEVEL_3V3'))        define('Y_I2CVOLTAGELEVEL_3V3',       1);
if(!defined('Y_I2CVOLTAGELEVEL_1V8'))        define('Y_I2CVOLTAGELEVEL_1V8',       2);
if(!defined('Y_I2CVOLTAGELEVEL_INVALID'))    define('Y_I2CVOLTAGELEVEL_INVALID',   -1);
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
if(!defined('Y_I2CMODE_INVALID'))            define('Y_I2CMODE_INVALID',           YAPI_INVALID_STRING);
//--- (end of YI2cPort definitions)
    #--- (YI2cPort yapiwrapper)
   #--- (end of YI2cPort yapiwrapper)

//--- (YI2cPort declaration)
/**
 * YI2cPort Class: I2C Port function interface
 *
 * The I2cPort function interface allows you to fully drive a Yoctopuce
 * I2C port, to send and receive data, and to configure communication
 * parameters (baud rate, etc).
 * Note that Yoctopuce I2C ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YI2cPort extends YFunction
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
    const I2CVOLTAGELEVEL_OFF            = 0;
    const I2CVOLTAGELEVEL_3V3            = 1;
    const I2CVOLTAGELEVEL_1V8            = 2;
    const I2CVOLTAGELEVEL_INVALID        = -1;
    const I2CMODE_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YI2cPort declaration)

    //--- (YI2cPort attributes)
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
    protected $_i2cVoltageLevel          = Y_I2CVOLTAGELEVEL_INVALID;    // I2cVoltageLevel
    protected $_i2cMode                  = Y_I2CMODE_INVALID;            // I2cMode
    protected $_rxptr                    = 0;                            // int
    protected $_rxbuff                   = "";                           // bin
    protected $_rxbuffptr                = 0;                            // int
    //--- (end of YI2cPort attributes)

    function __construct($str_func)
    {
        //--- (YI2cPort constructor)
        parent::__construct($str_func);
        $this->_className = 'I2cPort';

        //--- (end of YI2cPort constructor)
    }

    //--- (YI2cPort implementation)

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
        case 'i2cVoltageLevel':
            $this->_i2cVoltageLevel = intval($val);
            return 1;
        case 'i2cMode':
            $this->_i2cMode = $val;
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
     * Returns the latest message fully received (for Line and Frame protocols).
     *
     * @return string : a string corresponding to the latest message fully received (for Line and Frame protocols)
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
     * Returns the type of protocol used to send I2C messages, as a string.
     * Possible values are
     * "Line" for messages separated by LF or
     * "Char" for continuous stream of codes.
     *
     * @return string : a string corresponding to the type of protocol used to send I2C messages, as a string
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
     * Changes the type of protocol used to send I2C messages.
     * Possible values are
     * "Line" for messages separated by LF or
     * "Char" for continuous stream of codes.
     * The suffix "/[wait]ms" can be added to reduce the transmit rate so that there
     * is always at lest the specified number of milliseconds between each message sent.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the type of protocol used to send I2C messages
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
     * Returns the voltage level used on the I2C bus.
     *
     * @return integer : a value among Y_I2CVOLTAGELEVEL_OFF, Y_I2CVOLTAGELEVEL_3V3 and
     * Y_I2CVOLTAGELEVEL_1V8 corresponding to the voltage level used on the I2C bus
     *
     * On failure, throws an exception or returns Y_I2CVOLTAGELEVEL_INVALID.
     */
    public function get_i2cVoltageLevel()
    {
        // $res                    is a enumI2CVOLTAGELEVEL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_I2CVOLTAGELEVEL_INVALID;
            }
        }
        $res = $this->_i2cVoltageLevel;
        return $res;
    }

    /**
     * Changes the voltage level used on the I2C bus.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param integer $newval : a value among Y_I2CVOLTAGELEVEL_OFF, Y_I2CVOLTAGELEVEL_3V3 and
     * Y_I2CVOLTAGELEVEL_1V8 corresponding to the voltage level used on the I2C bus
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_i2cVoltageLevel($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("i2cVoltageLevel",$rest_val);
    }

    /**
     * Returns the SPI port communication parameters, as a string such as
     * "400kbps,2000ms,NoRestart". The string includes the baud rate, the
     * recovery delay after communications errors, and if needed the option
     * NoRestart to use a Stop/Start sequence instead of the
     * Restart state when performing read on the I2C bus.
     *
     * @return string : a string corresponding to the SPI port communication parameters, as a string such as
     *         "400kbps,2000ms,NoRestart"
     *
     * On failure, throws an exception or returns Y_I2CMODE_INVALID.
     */
    public function get_i2cMode()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_I2CMODE_INVALID;
            }
        }
        $res = $this->_i2cMode;
        return $res;
    }

    /**
     * Changes the SPI port communication parameters, with a string such as
     * "400kbps,2000ms". The string includes the baud rate, the
     * recovery delay after communications errors, and if needed the option
     * NoRestart to use a Stop/Start sequence instead of the
     * Restart state when performing read on the I2C bus.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the SPI port communication parameters, with a string such as
     *         "400kbps,2000ms"
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_i2cMode($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("i2cMode",$rest_val);
    }

    /**
     * Retrieves an I2C port for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the I2C port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YI2cPort.isOnline() to test if the I2C port is
     * indeed online at a given time. In case of ambiguity when looking for
     * an I2C port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the I2C port
     *
     * @return YI2cPort : a YI2cPort object allowing you to drive the I2C port.
     */
    public static function FindI2cPort($func)
    {
        // $obj                    is a YI2cPort;
        $obj = YFunction::_FindFromCache('I2cPort', $func);
        if ($obj == null) {
            $obj = new YI2cPort($func);
            YFunction::_AddToCache('I2cPort', $func, $obj);
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
     * @return a string with a single line of text
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
     * @param pattern : a limited regular expression describing the expected message format,
     *         or an empty string if all messages should be returned (no filtering).
     *         When using binary protocols, the format applies to the hexadecimal
     *         representation of the message.
     * @param maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return an array of strings containing the messages found, if any.
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
     * @param absPos : the absolute position index for next read operations.
     *
     * @return nothing.
     */
    public function read_seek($absPos)
    {
        $this->_rxptr = $absPos;
        return YAPI_SUCCESS;
    }

    /**
     * Returns the current absolute stream position pointer of the API object.
     *
     * @return the absolute position index for next read operations.
     */
    public function read_tell()
    {
        return $this->_rxptr;
    }

    /**
     * Returns the number of bytes available to read in the input buffer starting from the
     * current absolute stream position pointer of the API object.
     *
     * @return the number of bytes available to read
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
     * @param query : the line query to send (without CR/LF)
     * @param maxWait : the maximum number of milliseconds to wait for a reply.
     *
     * @return the next text line received after sending the text query, as a string.
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
     * @param jobfile : name of the job file to save on the device filesystem
     * @param jsonDef : a string containing a JSON definition of the job
     *
     * @return YAPI_SUCCESS if the call succeeds.
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
     * @param jobfile : name of the job file (on the device filesystem)
     *
     * @return YAPI_SUCCESS if the call succeeds.
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
     * Sends a one-way message (provided as a a binary buffer) to a device on the I2C bus.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param integer $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param string $buff : the binary buffer to be sent
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function i2cSendBin($slaveAddr,$buff)
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = strlen($buff);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = ord($buff[$idx]);
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(strlen($reply) > 0)) return $this->_throw( YAPI_IO_ERROR, 'No response from I2C device',YAPI_IO_ERROR);
        $idx = Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'No I2C ACK received',YAPI_IO_ERROR);
        $idx = Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'I2C protocol error',YAPI_IO_ERROR);
        return YAPI_SUCCESS;
    }

    /**
     * Sends a one-way message (provided as a list of integer) to a device on the I2C bus.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param integer $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param Integer[] $values : a list of data bytes to be sent
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function i2cSendArray($slaveAddr,$values)
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = sizeof($values);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = $values[$idx];
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(strlen($reply) > 0)) return $this->_throw( YAPI_IO_ERROR, 'No response from I2C device',YAPI_IO_ERROR);
        $idx = Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'No I2C ACK received',YAPI_IO_ERROR);
        $idx = Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'I2C protocol error',YAPI_IO_ERROR);
        return YAPI_SUCCESS;
    }

    /**
     * Sends a one-way message (provided as a a binary buffer) to a device on the I2C bus,
     * then read back the specified number of bytes from device.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param integer $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param string $buff : the binary buffer to be sent
     * @param integer $rcvCount : the number of bytes to receive once the data bytes are sent
     *
     * @return string : a list of bytes with the data received from slave device.
     *
     * On failure, throws an exception or returns an empty binary buffer.
     */
    public function i2cSendAndReceiveBin($slaveAddr,$buff,$rcvCount)
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        // $rcvbytes               is a bin;
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = strlen($buff);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = ord($buff[$idx]);
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }
        $idx = 0;
        while ($idx < $rcvCount) {
            $msg = sprintf('%sxx', $msg);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        $rcvbytes = '';
        if (!(strlen($reply) > 0)) return $this->_throw( YAPI_IO_ERROR, 'No response from I2C device',$rcvbytes);
        $idx = Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'No I2C ACK received',$rcvbytes);
        $idx = Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'I2C protocol error',$rcvbytes);
        $reply = substr($reply,  strlen($reply)-2*$rcvCount, 2*$rcvCount);
        $rcvbytes = YAPI::_hexStrToBin($reply);
        return $rcvbytes;
    }

    /**
     * Sends a one-way message (provided as a list of integer) to a device on the I2C bus,
     * then read back the specified number of bytes from device.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param integer $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param Integer[] $values : a list of data bytes to be sent
     * @param integer $rcvCount : the number of bytes to receive once the data bytes are sent
     *
     * @return Integer[] : a list of bytes with the data received from slave device.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function i2cSendAndReceiveArray($slaveAddr,$values,$rcvCount)
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        // $rcvbytes               is a bin;
        $res = Array();         // intArr;
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = sizeof($values);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = $values[$idx];
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }
        $idx = 0;
        while ($idx < $rcvCount) {
            $msg = sprintf('%sxx', $msg);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(strlen($reply) > 0)) return $this->_throw( YAPI_IO_ERROR, 'No response from I2C device',$res);
        $idx = Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'No I2C ACK received',$res);
        $idx = Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw( YAPI_IO_ERROR, 'I2C protocol error',$res);
        $reply = substr($reply,  strlen($reply)-2*$rcvCount, 2*$rcvCount);
        $rcvbytes = YAPI::_hexStrToBin($reply);
        while(sizeof($res) > 0) { array_pop($res); };
        $idx = 0;
        while ($idx < $rcvCount) {
            $val = ord($rcvbytes[$idx]);
            $res[] = $val;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Sends a text-encoded I2C code stream to the I2C bus, as is.
     * An I2C code stream is a string made of hexadecimal data bytes,
     * but that may also include the I2C state transitions code:
     * "{S}" to emit a start condition,
     * "{R}" for a repeated start condition,
     * "{P}" for a stop condition,
     * "xx" for receiving a data byte,
     * "{A}" to ack a data byte received and
     * "{N}" to nack a data byte received.
     * If a newline ("\n") is included in the stream, the message
     * will be terminated and a newline will also be added to the
     * receive stream.
     *
     * @param string $codes : the code stream to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeStr($codes)
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = $codes;
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
                return $this->sendCommand(sprintf('+%s',$codes));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a text-encoded I2C code stream to the I2C bus, and terminate
     * the message en relâchant le bus.
     * An I2C code stream is a string made of hexadecimal data bytes,
     * but that may also include the I2C state transitions code:
     * "{S}" to emit a start condition,
     * "{R}" for a repeated start condition,
     * "{P}" for a stop condition,
     * "xx" for receiving a data byte,
     * "{A}" to ack a data byte received and
     * "{N}" to nack a data byte received.
     * At the end of the stream, a stop condition is added if missing
     * and a newline is added to the receive buffer as well.
     *
     * @param string $codes : the code stream to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeLine($codes)
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        $bufflen = strlen($codes);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('!%s',$codes));
        }
        // send string using file upload
        $buff = sprintf('%s'."\n".'', $codes);
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a single byte to the I2C bus. Depending on the I2C bus state, the byte
     * will be interpreted as an address byte or a data byte.
     *
     * @param integer $code : the byte to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeByte($code)
    {
        return $this->sendCommand(sprintf('+%02X', $code));
    }

    /**
     * Sends a byte sequence (provided as a hexadecimal string) to the I2C bus.
     * Depending on the I2C bus state, the first byte will be interpreted as an
     * address byte or a data byte.
     *
     * @param string $hexString : a string of hexadecimal byte codes
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeHex($hexString)
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        $bufflen = strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('+%s',$hexString));
        }
        $buff = $hexString;

        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a binary buffer to the I2C bus, as is.
     * Depending on the I2C bus state, the first byte will be interpreted
     * as an address byte or a data byte.
     *
     * @param string $buff : the binary buffer to send
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeBin($buff)
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        $msg = '';
        $nBytes = strlen($buff);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = ord($buff[$idx]);
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        return $this->writeHex($msg);
    }

    /**
     * Sends a byte sequence (provided as a list of bytes) to the I2C bus.
     * Depending on the I2C bus state, the first byte will be interpreted as an
     * address byte or a data byte.
     *
     * @param Integer[] $byteList : a list of byte codes
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeArray($byteList)
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        $msg = '';
        $nBytes = sizeof($byteList);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = $byteList[$idx];
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        return $this->writeHex($msg);
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

    public function i2cVoltageLevel()
    { return $this->get_i2cVoltageLevel(); }

    public function setI2cVoltageLevel($newval)
    { return $this->set_i2cVoltageLevel($newval); }

    public function i2cMode()
    { return $this->get_i2cMode(); }

    public function setI2cMode($newval)
    { return $this->set_i2cMode($newval); }

    /**
     * Continues the enumeration of I2C ports started using yFirstI2cPort().
     * Caution: You can't make any assumption about the returned I2C ports order.
     * If you want to find a specific an I2C port, use I2cPort.findI2cPort()
     * and a hardwareID or a logical name.
     *
     * @return YI2cPort : a pointer to a YI2cPort object, corresponding to
     *         an I2C port currently online, or a null pointer
     *         if there are no more I2C ports to enumerate.
     */
    public function nextI2cPort()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindI2cPort($next_hwid);
    }

    /**
     * Starts the enumeration of I2C ports currently accessible.
     * Use the method YI2cPort.nextI2cPort() to iterate on
     * next I2C ports.
     *
     * @return YI2cPort : a pointer to a YI2cPort object, corresponding to
     *         the first I2C port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstI2cPort()
    {   $next_hwid = YAPI::getFirstHardwareId('I2cPort');
        if($next_hwid == null) return null;
        return self::FindI2cPort($next_hwid);
    }

    //--- (end of YI2cPort implementation)

};

//--- (YI2cPort functions)

/**
 * Retrieves an I2C port for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the I2C port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YI2cPort.isOnline() to test if the I2C port is
 * indeed online at a given time. In case of ambiguity when looking for
 * an I2C port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the I2C port
 *
 * @return YI2cPort : a YI2cPort object allowing you to drive the I2C port.
 */
function yFindI2cPort($func)
{
    return YI2cPort::FindI2cPort($func);
}

/**
 * Starts the enumeration of I2C ports currently accessible.
 * Use the method YI2cPort.nextI2cPort() to iterate on
 * next I2C ports.
 *
 * @return YI2cPort : a pointer to a YI2cPort object, corresponding to
 *         the first I2C port currently online, or a null pointer
 *         if there are none.
 */
function yFirstI2cPort()
{
    return YI2cPort::FirstI2cPort();
}

//--- (end of YI2cPort functions)
?>