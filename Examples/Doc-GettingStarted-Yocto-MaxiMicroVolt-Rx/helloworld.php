<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_genericSensor.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $sensor = yFindGenericSensor("$serial.genericSensor1");
      if (!$sensor->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $sensor = yFirstGenericSensor();
      if(is_null($sensor)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $sensor->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  $sensor1 = yFindGenericSensor("$serial.genericSensor1");
  Printf("GenericSensor channel 1: %.1f %s<br>",$sensor1->get_currentValue(),$sensor1->get_unit());

  $sensor2 = yFindGenericSensor("$serial.genericSensor2");
  Printf("GenericSensor channel 2: %.1f %s<br>",$sensor2->get_currentValue(),$sensor2->get_unit());
  yFreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
