<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planner</title>
    <link rel = "stylesheet" href="styles/main_style.css">
</head>
<body onload="theClock(); setInterval('theClock()',1000)">
<?php include('views/header.html');?>
<?php include('scripts/php/present_schedule.php');?>
<!--The follow button create a new week into de calendar!-->
<form  action="scripts/php/create_week.php" method="post" target="_self">
  <input type="submit" name="" value="add week">
</form>
</body>
</html>
