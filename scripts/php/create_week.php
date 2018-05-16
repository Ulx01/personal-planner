<?php
 $week_days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday' );
 $weeks_date = array();
//function that creates a new week in the planner
  require('model/model.php');
  $model_connection =  new DatabaseModel();
  $check = $model_connection->check_week();
  $day = new DateTime(date("y-m-d"));
  if ($check->num_rows < 1) {
    looking_for_monday($day);
    print_r($day);
  }
  else {
    get_monday($day);
  }
$date_interval = new DateInterval('P7D');
$date_range = "".date("y-m-d",$day->getTimestamp());
$weeks_date = fill_week_date($day);
$date_range = $date_range." to ".date("y-m-d",$day->getTimestamp());
echo $date_range;
print_r($week_days);
print_r($weeks_date);
//$model_connection->get_last_monday($week_days,)
$model_connection->fill_week($week_days, $weeks_date, $date_range);

//this function is looking for the next monday
  function looking_for_monday($day)
  {
    $date_interval = new DateInterval('P1D');
    while (getdate($day->getTimestamp())['wday'] != 1) {
      $day->add($date_interval);
    }
  }

  function get_monday($day)
  {
    $date_interval = new DateInterval('P7D');
    $day->add($date_interval);
  }

//function that set the dates of the weeks days
  function fill_week_date($day_to_iterate)
  {
    $date_interval = new DateInterval('P1D');
    $iterator = 1;
    $weeks_date = array();
    $weeks_date[0]=date("y-m-d",$day_to_iterate->getTimestamp());
    while($iterator < 7)
    {
      $day_to_iterate->add($date_interval);
      $weeks_date[$iterator]=date("y-m-d",$day_to_iterate->getTimestamp());
    //  echo date("y-m-d",$day_to_iterate->getTimestamp());
      $iterator = $iterator + 1;
    }

    return $weeks_date;
  }
?>
