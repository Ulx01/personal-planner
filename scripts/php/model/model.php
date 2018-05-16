<?php
  /**
   *
   */
  class DatabaseModel
  {
    public $connection;

    function __construct()
    {
      # code...
      date_default_timezone_set('US/Eastern');
      $this->connection = new mysqli("127.0.0.1","root","","personal-planner");
      if($this->connection->connect_errno){
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
    }


    public function check_week()
    {
      $check = $this->connection->query("select * from week");
      return $check;
    }

    public function get_last_monday()
    {

    }

//Esta funcion inserta en la base de datos la informacion sobre los dias y su nombre y su ID
    public function fill_week($week_days, $weeks_date, $date_range)
    {
      $week_id = "";
      $array_iterator = 0;
      if(!($query = $this->connection->prepare("insert into week(date_range) values(?)")))
      {
        echo "Prepare failed: (" . $this->connection->errno . ") " . $this->connection->error;
      }
      if(!($query->bind_param("s",$date_range))){
        echo "Bind failed: (" . $this->connection->errno . ") " . $this->connection->error;
      }
      if (!$query->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          }
      $result = $this->connection->query("select week_id from week order by week_id desc limit 1");
      /*if(!($this->connection->query("select week_id from week order by week_id desc limit 1")))
      {
        echo "Execute failed: (" . $this->connection->errno . ") " . $this->connection->error;
      }*/
      while($row = $result->fetch_assoc()){
        $week_id = $row['week_id'];
      }

      if(!($query = $this->connection->prepare("insert into day(day_name, day_date) values(?,?)")))
      {
        echo "Prepare failed: (" . $this->connection->errno . ") " . $this->connection->error;
      }
      while ($array_iterator < count($week_days)) {
        if(!$query->bind_param("ss",$week_days[$array_iterator],$weeks_date[$array_iterator]))
        {
          echo "Bind problems".$query->errno;
        }
        if (!$query->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        $array_iterator = $array_iterator + 1;
      }
      //enlazar days con week
      if(!($query = $this->connection->prepare("insert into week_day(week_id,day_id) values(?,?)")))
      {
        echo "Prepare failed: (" . $this->connection->errno . ") " . $this->connection->error;
      }
      $result = $this->connection->query("select day_id from day order by day_id desc limit 7");
      while($row = $result->fetch_assoc()){
        if(!$query->bind_param("ii",$week_id,$row['day_id'])){
          echo "Bind problems".$query->errno;
        }
        if (!$query->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
      }

    }

    public function retrieve_weeks()
    {
      $array = [];
      $result = $this->connection->query("select date_range from week");
      while ($row = $result->fetch_assoc()) {
        array_push($array, $row['date_range']);
      }
      return $array;
    }

    public function retrieve_days($date_range_array)
    {
      $temporal = [];
      $array = [];
      if((!$query = $this->connection->prepare("SELECT
          day_name, day_date FROM
          week_day INNER JOIN week on week_day.week_id = week.week_id
          INNER JOIN day on week_day.day_id = day.day_id where date_range =?")))
          {
            echo "Prepare failed: (" . $this->connection->errno . ") " . $this->connection->error;
          }
          foreach ($date_range_array as $value) {
            $query->bind_param("s",$value);
            $query->execute();
            $result = $query->get_result();
            while ($row = $result->fetch_assoc()) {
              array_push($temporal,$row['day_date']);
            }
            $array[$value] = $temporal;
            $temporal = [];
          }
        return $array;
    }
  }


?>
