<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Invoice</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
	<style>

		@page {
			margin:0px;
			background-color: #f4f4f4;
		}

		@media print {
			body{
				margin:0;
				background-color: rgb(255, 87, 51);
				-webkit-print-color-adjust: exact !important;
			}
			html { margin: 0px}
		}

		body {
			margin: 0px;
			background-color: rgb(255, 87, 51);
		}
		html { margin: 0px}
		.invoice-header{
			position: fixed;
			margin-top: 0px;
			left:0;
			right: 0;
			background-color: #f7d3a7;
			height:90px;
			width: 100%;
		}

		.invoice-text{
			position: fixed;
			margin-top: 90px;
			width: 100px;
			padding: 10px;
			height: 30px;
			background-color: #ffffff;
			left:15px;
			font-weight: 800;
			font-family: 'Lato', sans-serif;
			text-transform: uppercase;
			font-size: 25px;
			transform: rotate(270deg);
			color: #525659;
		}

		.invoice-left{
			position: fixed;
			margin-top: 90px;
			left:0;
			width: 250px;
			/*right: 80%;*/
			/*bottom:0;*/
			/*height:90px;*/
			/*border: 1px solid black;*/
		}

		.invoice-right{
			position: fixed;
			margin-top: 150px;
			right:0;
			width: 570px;
			/*border: 1px solid black;*/
		}

		.invoice-to{
			position: fixed;
			margin-top: 250px;
			width: 200px;
			padding: 10px;
			height: 100px;
			left:30px;
			font-size: 12px;
			line-height:1.1em;
			/*border: 1px solid black;*/
			color: #525659;
		}

		.invoice-from{
			position: fixed;
			margin-top: 500px;
			width: 200px;
			padding: 10px;
			height: 100px;
			left:30px;
			font-weight: 900;
			font-size: 12px;
			line-height:1.1em;
			/*border: 1px solid black;*/
			/*color: #525659;*/
		}

		table.invoice-products{
			border-collapse:collapse;
		}

		.invoice-products table{
			font-weight: 300;
			font-size: 12px;
			font-family: 'Lato', sans-serif;
		}

		.invoice-products th{
			padding:20px;
			font-weight: 700;
			font-family: 'Lato', sans-serif;
		}

		.invoice-products td{
			font-weight: 400;
			font-family: 'Lato', sans-serif;
			padding:20px;
		}

		.invoice-products td, .invoice-products th {
			border-bottom: 1px solid #525659 !important;
		}


		/*table:nth-child(2) th:nth-child(2),td:nth-child(2){*/
		/*text-align: center;*/
		/*}*/
		/*table:nth-child(2) th:nth-child(3),td:nth-child(3){*/
		/*text-align: right;*/
		/*}*/


	</style>
</head>

<body>

<div class="invoice-header">

	<table border="0" width="100%" style="margin-top: 40px; color: #525659;">
		<tbody>
		<tr>
			<td width="60%" style="font-family:'Lato Regular', sans-serif;text-transform: uppercase;text-align: right;font-size: 12px;font-weight: 400;">
				Date: <?php echo $wpifw_order_date; ?><br/>
				Order no. - <?php echo $id; ?><br/>
			</td>
			<td style="font-family:'Lato Regular', sans-serif;text-transform: uppercase;text-align: center;font-size: 25px;font-weight: 700;">#578940</td>
		</tr>
		</tbody>
	</table>
</div>
<div class="invoice-text">
	Invoice
</div>
<br>
<div class="invoice-left">
	<div class="invoice-to">
		<b>TO</b><br>
		<b>MD OHIDUL ISLAM</b> <br>
		WebAppick <br>
		16 A/03, Ring Road, <br> Mohammadpur <br>
		Dhaka-1207
	</div>
	<div class="invoice-from">
		<b>FROM</b><br>
		<b>MD OHIDUL ISLAM</b> <br>
		WebAppick <br>
		16 A/03, Ring Road, <br> Mohammadpur <br>
		Dhaka-1207
	</div>
</div>
<div class="invoice-right">
	<table border="0" width="90%" class="invoice-products">
		<thead>
		<tr>
			<th>Description</th>
			<th>Qty</th>
			<th>Amount</th>
		</tr>
		</thead>
		<tbody>
		<?php
		//        echo $products[1]['name'];
		//        print_r($products);die();if($products){
		foreach ($products as $key=>$value){
			$html="<tr>";
			$html.="<td>".$value['name']."</td>";
			$html.="<td>".$value['quantity']."</td>";
			$html.="<td>".$value['subtotal']."</td>";
			$html.="</tr>";
		}



		echo $html;

		?>

		</tbody>
	</table>
</div>
</body>
</html>
