<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_i2cport.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $i2cport = yFindI2cPort("$serial.i2cPort");
      if (!$i2cport->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $i2cport = yFirstI2cPort();
      if(is_null($i2cport)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $i2cport->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>\n");

  // sample code reading MCP9804 temperature sensor
  $i2cport->set_i2cMode("400kbps");
  $i2cport->set_i2cVoltageLevel(Y_I2CVOLTAGELEVEL_3V3);
  $i2cport->reset();
  Print("****************************<br>\n");
  Print("* make sure voltage levels *<br>\n");
  Print("* are properly configured  *<br>\n");
  Print("****************************<br>\n");
  $toSend = [0x05];
  $received = $i2cport->i2cSendAndReceiveArray(0x1f, $toSend, 2);
  $tempReg = ($received[0] << 8) + $received[1];
  if($tempReg & 0x1000) {
    $tempReg -= 0x2000;   // perform sign extension
  } else {
    $tempReg &= 0x0fff;   // clear status bits
  }
  Printf("Temperature: %.3f &deg;C<br>\n", ($tempReg / 16.0));
  yFreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
