<?php
$cluster   = cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
$session   = $cluster->connect("stats");
$sensor_id=$_GET["sensor_id"];
$date=date(Ymd);
$add_value=$_GET["value"];
    echo "sensor id is" .$sensor_id . "<br>" ;
    echo "date is " .$date . "<br>" ;
    echo "add value is " .$add_value . "<br>" ;
$statement = new Cassandra\SimpleStatement("select sensor_id, date, value from daily_metrics_bysensor_id where sensor_id='$sensor_id' and date=$date;");
$result    = $session->execute($statement);
foreach ($result as $row) {
        echo $row['sensor_id'] . ": ". $row['date'] . ": " . $row['value'] . "<br>" ;
$old_value=$row['value'];
echo "old value is ". $old_value. "<br>" ;
		}
		

$new_value=$add_value+$old_value;
echo "new value : " .$new_value. "<br>" ;

$statement_update_value = new Cassandra\SimpleStatement("Update daily_metrics_bysensor_id set VALUE=$new_value where sensor_id='$sensor_id' and date=$date");
$result_update_value = $session->execute($statement_update_value);
$statement_update_counter = new Cassandra\SimpleStatement("UPDATE counter_metrics_bysensor_id_and_by_date set daily_counter=daily_counter+1 where sensor_id='$sensor_id' and date=$date");
$result_counter    = $session->execute($statement_update_counter);
echo "DONE!!!";

?>

