<?php $login_req = true; $_title = 'Progress'; $_page = 'progress'; require_once('header.php'); ?>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<div id="content" class="box">

<div style="overflow: hidden; width: 100%; height: 1000px">
 <h1>Progress</h1>
 <script type="text/javascript">
 
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'barscontainer',
                type: 'column'
            },
            title: {
                text: 'Course Progress'
            },
            xAxis: {
                categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5',/* 'Week 6', 'Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12', 'Week 13',*/ 'Total'/*, 'Final'*/]
            },
            legend: {
            	enabled: false
            },
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Marks'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    },
                    formatter: function() {return this.total + '%'; }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.y +'%<br/>'+
                        'Total: '+ this.point.stackTotal + '%';
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: ' ',
                data: [<?php              
              $total = 0;  
for($week = 1; $week <= 5; $week++)
{
	$noofques = $db->GetRow("SELECT COUNT(*) as cnt FROM cw_seqques2 WHERE section=? AND type != '4'", $week + 1);
	if($noofques['cnt'] == 0) $noofques['cnt'] = 1;
	$res = $db->GetRow("SELECT COUNT(*) as cnt FROM cw_submissions WHERE ques=ANY (SELECT id FROM cw_seqques2 WHERE section=?) AND status='1' AND user=? AND graded='1' LIMIT 1", array($week + 1, $_SESSION['uid']));
	
	$total += intval($res['cnt'])/$noofques['cnt']*100;
	echo intval(intval($res['cnt'])/$noofques['cnt']*100);
	echo ',';
}
echo "{ color: '#FF5555', y: " . intval($total / 5) . "}";
/*
echo ',';
$noofques = $db->GetRow("SELECT COUNT(*) as cnt FROM cw_seqques WHERE section=? AND type != '4'", 15);
if($noofques['cnt'] == 0) $noofques['cnt'] = 1;
$res = $db->GetRow("SELECT COUNT(*) as cnt FROM cw_submissions WHERE ques=ANY (SELECT id FROM cw_seqques WHERE section=?) AND status='1' AND user=? AND graded='1' LIMIT 1", array(15, $_SESSION['uid']));
echo intval(intval($res['cnt'])/$noofques['cnt']*100);
	
*/
?>]
            }, ],
        });
    });
    
});

</script> 

<div id="barscontainer" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

</div>

<div>

	
</div>
</div>
<?php require_once('footer.php'); ?>