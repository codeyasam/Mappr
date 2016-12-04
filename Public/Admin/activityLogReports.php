<?php require_once('../../includes/initialize.php'); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php 
	require('../../includes/tcpdf/tcpdf.php');
	$pdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetAutoPageBreak(true, 15);
	$pdf->AddPage();

	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

?>
<?php 

	$user = User::find_by_id($session->user_id);
	$user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null;

	$all_user_activities = null;
	$selected_user = null;
	$htmlheader = "";
	if (isset($_GET['id'])) {
		$selected_user = User::find_by_id($_GET['id']);

		if ($selected_user->user_type != "ADMIN" && $selected_user->user_type != "OWNER") redirect_to('manageAdmins.php');
		if (isset($_GET['fromDate']) && isset($_GET['toDate']) && isset($_GET['description'])) {
			$all_user_activities = array_reverse(MapprActLog::getUserRecords($selected_user->id, $_GET['fromDate'], $_GET['toDate'], $_GET['description']));		
			$htmlheader .= 'Activity Logs of [ <b>' . ucwords($selected_user->full_name()) . "</b> ] From [ <b>" . $_GET['fromDate'] . "</b> ] To [ <b>" . $_GET['toDate'] . "</b> ]";
			if (!empty($_GET['description'])) {
				$htmlheader .= " with [ <b>" . $_GET['description'] . "</b> ] as keywords";
			}
		} else {
			$all_user_activities =  array_reverse(MapprActLog::find_all(array('key'=>'user_id', 'value'=>$selected_user->id, 'isNumeric'=>true)));
			$htmlheader .= "All Activity Logs of [ <b>" . ucwords($selected_user->full_name()) . "</b> ]";
		}

		$htmlheader = "<small>" . ucwords($htmlheader) . "</small>";
	} else {
		redirect_to('../index.php');
	}
	

	$htmlContent = "<br/><br/>";
	$htmlContent .=	'
	<style>
		table {
			border-collapse: collapse;
		 	width: 500px;
		 	margin: 0 auto;
		}

		td {
			padding: 50px;
		}

		th {
			color: #333;
			background-color: #efdb00;
			font-weight:bolder;
			text-align:center;
			letter-spacing: 1px;
			font-weight:bolder;
		}

		h1 {
			font-size: 2em;
		}

		td h1, td h5 {
			text-align: left;
		}

		.logo {
			text-align: right;
		}

		h3 {
			text-align: center;
			text-transform: uppercase;
		}
	</style>
	<table border=1>
		<tr>
			<td width="200px" class="logo" rowspan="2"><img width="50px" src="../images/logo.png"></td>
			<td><h1><b>COIN ONE</b></h1></td>
		</tr>
		<tr>
			<td><h5>Business Locator</h5></td>
		</tr>
	</table>
	
	
	<h3>'. ucwords($selected_user->full_name()) . ' Activity Logs</h3>
	<table>
		<tr>
			<th>DESCRIPTION</th>
			<th>DATE AND TIME</th>
		</tr>'; 	
	$isGrey = false;
	foreach ($all_user_activities as $key => $each_activity) {

				$htmlContent .= '<tr style="background-color:' . ($isGrey ? "#ddd" : "#fff" ) . '">
					<td>' . htmlentities($each_activity->description) . '</td>
					<td>' . htmlentities(format_date($each_activity->processed_date)) . '</td>
				</tr>';

				$isGrey = !$isGrey;		
	}

	$htmlContent .= '</table>';
	$htmlContent .= '<p>Exported by: ' . $user->full_name() . ' ' . format_date(get_mysql_datetime(time())) . '</p>';
	$pdf->WriteHTML($htmlheader);

	$pdf->WriteHTML($htmlContent);
	ob_end_clean(); 
	$pdf->Output('UserActivityLogReport.pdf', 'I');	
?>