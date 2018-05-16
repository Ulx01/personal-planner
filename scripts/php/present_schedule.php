<?php
require('model/model.php');
$week_days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday' );
$model_connection =  new DatabaseModel();
$date_range_array = $model_connection->retrieve_weeks();
$schedule_array = $model_connection->retrieve_days($date_range_array);
echo "<br>";
echo "<section class='week'>";
foreach ($schedule_array as $key => $value) {
  echo "<section class='week'>
  <h2> Week from ".$key."</h2>
  <div class='row remove-overflow-y'>";
  foreach (array_combine($week_days,array_reverse($value)) as $key => $value) {
    echo "<div class='monday day'>
        <h3 class='day-header'>".$key." ".$value."</h3>
        <div class='text-block'>
          <ul>
            <li>Lorem ipsum</li>
            <li>Lorem ipsum</li>
            <li>Lorem ipsum</li>
            <li>Lorem ipsum</li>
            <li>Lorem ipsum</li>
            <li>Lorem ipsum</li><li>Lorem ipsum</li>
            <li>Lorem ipsum</li>
          </ul>
        </div>
    <button class='btn'>Add a event</button>
    </div>";
  }
  echo "</div>";
}
?>
