<?php

$pageBreak='class="teacherPage"';
$html = <<<HTML
  <html>
  <title>Invoice</title>
      <head>
            <style type="text/css">
  

.teacherPage {
   page: teacher;
   page-break-after: always;
}

body{
    background-color: #ebe9ea;
}

@page  {
    margin: 0px;
}

.logo{
    border: 1px solid black;
    position: fixed;
    top:40px;
    left:40px;
    width: 200px;
}

.invoice{
    border: 1px solid black;
    position: fixed;
    top:40px;
    right:40px;
    width: 200px;
    text-transform: uppercase;
    font-size:30px;
    font-weight: bold;
}

.headerInfo{
    border: 1px solid black;
    position: fixed;
    top:100px;
    width: 100%;
    padding: 10px;
}
.productInfo{
    border: 1px solid black;
    position: absolute;
    /*top:200px;*/
    /*width: 100%;*/
    /*padding: 10px;*/
}

            </style>
      </head>
      <body>



HTML;

foreach ($orders as $order_id=>$order){

    //echo "<pre>";print_r($order);
    $billing= "<b>".$order['billing']['first_name']." ".$order['billing']['last_name']."</b>"."\n".$order['billing']['address_1']."\n".$order['billing']['address_2']."\n".$order['billing']['city']."\n".$order['billing']['state']."\n".$order['billing']['postcode']."\n".$order['billing']['country']."\n".$order['billing']['email']."\n".$order['billing']['phone']."\n";


    # Extract Order Information
    extract($order);

    # Calculate page by product quantity
    $page=ceil(count($wpifw_products)/3);

    for($i=1;$i <= $page;$i++){

        if($i==$page){
	        $pageBreak="";
        }

	    $html .= <<<HTML
<div class="logo">
<!--<img src="https://webappick.com/wp-content/uploads/2017/05/Logo.png" width="84" height="42" alt="">-->
ASD
</div>
<div class="invoice">
 Invoice
</div>

<div class="headerInfo">
<table width="90%">
    <thead>
        <tr>
            <th>To</th>
            <th>From</th>
            <th>Shipping Address</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="30%">
                $billing 
                            
            </td>
            <td width="30%">
                Site Name
                Site Address
            </td>
            <td width="30%">
             $billing 
            </td>
        </tr>
    </tbody>
</table>
</div>
<div class="productInfo">
HTML;

	    $html .= "<div $pageBreak >";
	    $html .= "Order ID:".$page  ."<br/>";
	    $html .= "Order Date:".$wpifw_order_date."<br/>";

	    $html.="<table width='70%'>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>";

                if($wpifw_products){
                    $p=0;
                    foreach ($wpifw_products as $key=>$value){
                        if($p==3){
                            break;
                        }
                        $html.="<tr>";
                        $html.="<td>".$value['name']."</td>";
                        $html.="<td>".$value['subtotal']."</td>";
                        $html.="<td>".$value['quantity']."</td>";
                        $html.="<td>".$value['quantity']*$value['subtotal']."</td>";
                        $html.="</tr>";
                        $p++;
                        unset($wpifw_products[$key]);
                    }
                }

                $html .= '</tbody>
                </table>';
                $html .= '</div>';

    }

}

$html .= '</div></body></html>';

echo $html;

//print_r($wpifw_products);
?>


