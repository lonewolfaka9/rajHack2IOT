<?php
$capacity = $_POST['dustbinID'];
$fill = $_POST['fill'];
$dutbin_array = array("Dustbin ");
print_r($dutbin_array);
$values = '<markers>
  <marker id="2" name="'.$capacity.'" address="'.$fill.'%" capacity="10" lat="25.2031837" lng="75.8643334" type="restaurant"/>
  <marker id="2" name="Dustbin 2" address="Capacity : 50% filled" capacity="10" lat="25.199853" lng="75.857377" type="restaurant"/>
  <marker id="3" name="Dustbin 3" address="Capacity : 80% filled" capacity="10" lat="25.179508" lng="75.855440" type="restaurant"/>
  <marker id="4" name="Dustbin 4" address="Capacity : 30% filled" capacity="10" lat="25.185268" lng="75.870218" type="restaurant"/>
  <marker id="5" name="Dustbin 5" address="Capacity : 57% filled" capacity="10" lat="25.187365" lng="75.879058" type="restaurant"/>
  <marker id="6" name="Dustbin 6" address="Capacity : 90% filled" capacity="10" lat="25.200801" lng="75.833654" type="restaurant"/>
  <marker id="7" name="Dustbin 7" address="Capacity : 45% filled" capacity="10" lat="25.196297" lng="75.825843" type="restaurant"/>
  <marker id="8" name="Dustbin 8" address="Capacity : 66% filled" capacity="10" lat="25.192196" lng="75.861091" type="restaurant"/>
  <marker id="9" name="Dustbin 9" address="Capacity : 89% filled" capacity="10" lat="25.176413" lng="75.874423" type="restaurant"/>
</markers>';


$data = array($capacity,$fill);

$my_file = 'file.txt';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file

$my_file = 'markers2.xml';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
$data = 'This is the data';
fwrite($handle, $values);


echo "Hello World";
?>
