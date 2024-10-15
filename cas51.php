<?php
$cluster   = cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
$sensor_id=$_GET["sensor_id"];
$date=$_GET["date"];
echo $date;

$session   = $cluster->connect("stats");
    // Prepare the SQL statement

$statement = new Cassandra\SimpleStatement("select sensor_id, date, value from daily_metrics_bysensor_id where  sensor_id='$sensor_id' and date=$date;");
$result    = $session->execute($statement);
foreach ($result as $row) {
        echo $row['sensor_id'] . ": ". $row['date'] . ": " . $row['value'] . "<br>" ;
$sensor_id=$row['sensor_id'];
$value=$row['value'];

echo "old value is ". $old_value. "<br>" ;
$statement_counter = new Cassandra\SimpleStatement("select daily_counter from counter_metrics_bysensor_id_and_by_date where sensor_id='$sensor_id' and date=$date");
$result_counter    = $session->execute($statement_counter);
foreach ($result_counter as $row_counter) {
$counter_that_day=$row_counter['daily_counter'];
$average_of_the_day=$value/$counter_that_day;
 /*       echo "counter is ".$row_counter['daily_counter'] . "<br>" ;*/
        echo "Average satisfaction " . $average_of_the_day . "<br>" ;
}
}
?>
