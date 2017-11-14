
<div class="content_head">
    <h3></h3>
                       
</div>		<!-- .content_head ends -->

<div id="dashboard">
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.js"></script>
<h1>Water Activity Results Chart</h1>
<canvas id="myChart"  style="width:100%"></canvas>
<br/><br/><br/>
<h1>Plant Extract Profile Results Chart</h1>
<canvas id="myChart2"  style="width:100%"></canvas>
<?php
$sql_most_recent = "SELECT count(result) as result_num, date_created FROM default_transaction where id <> '' AND farmer_id = '".USER_ID."' AND type='water' AND result!='' GROUP BY date_created DESC LIMIT 10";

$query_most_recent = mysql_query($sql_most_recent);
//echo $sql_most_recent;
while( $row_most_recent = mysql_fetch_assoc( $query_most_recent)){
	$thearray[] = $row_most_recent['result_num'];
	$thearray2[] = $row_most_recent['date_created'];
}
//print_r($thearray);
$array =  implode ('","', $thearray2);
$array2 =  implode (', ', $thearray);
//print_r($array2);
?>
<?php
$sql_most_recent2 = "SELECT count(result) as result_num, date_created FROM default_transaction where id <> '' AND farmer_id = '".USER_ID."' AND type='tlc' AND result!='' GROUP BY date_created DESC LIMIT 10";

$query_most_recent2 = mysql_query($sql_most_recent2);
//echo $sql_most_recent;
while( $row_most_recent2 = mysql_fetch_assoc( $query_most_recent2)){
	$arrresultnum[] = $row_most_recent2['result_num'];
	$arrdatecreated[] = $row_most_recent2['date_created'];
}
//print_r($thearray);
$datecreated =  implode ('","', $arrdatecreated);
$resultnum =  implode (', ', $arrresultnum);
//print_r($array2);
?>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var ctx2 = document.getElementById("myChart2").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["<?=$array?>"],
        datasets: [{
            label: 'Water Activity Results Chart',
            data: [<?=$array2?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        },
		elements: {
            line: {
                tension: 0, // disables bezier curves
            }
        }
    }
});
var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ["<?=$datecreated?>"],
        datasets: [{
            label: 'Plant Activity Results Chart',
            data: [<?=$resultnum?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        },
		elements: {
            line: {
                tension: 0, // disables bezier curves
            }
        }
    }
});
</script>
   
</div>

