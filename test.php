<?php
// Get the dynamically generated inputs
$inputValues = $_POST['inputValues'];

// Print out the values of the dynamically generated inputs
foreach ($inputValues as $value) {
  echo $value . "<br>";
}
?>
