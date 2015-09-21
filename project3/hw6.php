<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="PHP, XML, eBay API (HW6)">
        <title>HW6: Server-side Scripting</title>
        <style>
            html{
                background-color: white;
            }
            body{
                margin: 0 auto;
                color: black;
            }
            h1{
                margin: 25px auto;
                width: 235px;
                line-height: 101px;
                background-image: url(ebay.jpg);
                background-size: 101px 101px;
                background-repeat: no-repeat;
                text-align: right;
                font-family: "Times New Roman", Georgia, serif;
            }
            form{
                min-width: 565px;
            	margin-left: 15px;
            	margin-right: 15px;
            	border: 2px solid black;
            }
            #mytable{
            	margin: 15px 20px 20px 15px;
            }
            #row1 td, #row2 td, #row3 td, #row4 td, #row5 td, #row6 td, #row7 td{
                border-bottom: 1px solid #D8D8D8;
            }
            .lable{
                min-width: 135px;
                font-family: "Times New Roman", Georgia, serif;
            	text-align: left;
                vertical-align: top;
            	font-weight: bold;
            }
            .form{
                width: 100%;
            }
            #keywords{
                width: 99%;
            }
            #button{
                text-align: right;
                
            }
            input.checkbox{
                background-color: #DEDEDE;
            }
            input.button{
                background: linear-gradient(#F4F4F4, #DEDEDE);
                border: 1px solid #A9A9A9;
                width: 60px;
            }
        </style>
    </head>
    <body>
    	<header>
            <h1>Shopping</h1>
    	</header>
    	<form id="myform" method="get">
    	<table id="mytable">
            <tbody>
    		<tr id="row1">
    			<td class="lable">Key Words*:</td>
    			<td class="form"><input id="keywords" name="keywords" value="<?php echo isset($_GET['keywords']) ? $_GET['keywords']:'' ?>" /></td>
    		</tr>
    		<tr id="row2">
    			<td class="lable">Price Range:</td>
    			<td class="form">from $<input type="number" step="any" id="pricefrom" name="pricefrom" size="8" value="<?php echo isset($_GET['pricefrom']) ? $_GET['pricefrom']:'' ?>"/> to $<input type="number" step="any" id="priceto" name="priceto" size="8" value="<?php echo isset($_GET['priceto']) ? $_GET['priceto']:'' ?>"/>
    			</td>
    		</tr>
    		<tr id="row3">
    			<td class="lable">Condition:</td>
    			<td class="form">
    				<input id="new" type="checkbox" class="checkbox" name="condition[]" value="1000" <?php if(!empty($_GET['condition']) && in_array('1000', $_GET['condition'])) echo "checked='checked'"; ?> />New&nbsp;
    				<input id="used" type="checkbox" class="checkbox" name="condition[]" value="3000" <?php if(!empty($_GET['condition']) && in_array('3000', $_GET['condition'])) echo "checked='checked'"; ?> />Used&nbsp;
    				<input id="verygood" type="checkbox" class="checkbox" name="condition[]" value="4000" <?php if(!empty($_GET['condition']) && in_array('4000', $_GET['condition'])) echo "checked='checked'"; ?> />Very Good&nbsp;
    				<input id="good" type="checkbox" class="checkbox" name="condition[]" value="5000" <?php if(!empty($_GET['condition']) && in_array('5000', $_GET['condition'])) echo "checked='checked'"; ?> />Good&nbsp;
    				<input id="acceptable" type="checkbox" class="checkbox" name="condition[]" value="6000" <?php if(!empty($_GET['condition']) && in_array('6000', $_GET['condition'])) echo "checked='checked'"; ?> />Acceptable
    			</td>
    		</tr>
    		<tr id="row4">
    			<td class="lable">Buying formates:</td>
    			<td class="form">
    				<input id="fixedprice" type="checkbox" class="checkbox" name="buyformates[]" value="FixedPrice" <?php if(!empty($_GET['buyformates']) && in_array('FixedPrice', $_GET['buyformates'])) echo "checked='checked'"; ?> />Buy It Now&nbsp;
    				<input id="auction" type="checkbox" class="checkbox" name="buyformates[]" value="Auction" <?php if(!empty($_GET['buyformates']) && in_array('Auction', $_GET['buyformates'])) echo "checked='checked'"; ?> />Auction&nbsp;
    				<input id="classified" type="checkbox" class="checkbox" name="buyformates[]" value="Classified" <?php if(!empty($_GET['buyformates']) && in_array('Classified', $_GET['buyformates'])) echo "checked='checked'"; ?> />Classified Ads
    			</td>
    		</tr>
    		<tr id="row5">
    			<td class="lable">Seller:</td>
    			<td class="form"><input id="raccepted" type="checkbox" class="checkbox" name="ReturnsAcceptedOnly" value="true" <?php if(isset($_GET['ReturnsAcceptedOnly'])) echo "checked='checked'"; ?> />Return accepted</td>
    		</tr>
    		<tr id="row6">
    			<td class="lable">Shipping:</td>
    			<td class="form">
    				<input id="freeship" type="checkbox" class="checkbox" name="freeship" value="freeship" <?php if(isset($_GET['freeship'])) echo "checked='checked'"; ?>/>Free Shipping<br>
    				<input id="expeditedship" type="checkbox" class="checkbox" name="expeditedship" value="expeditedship" <?php if(isset($_GET['expeditedship'])) echo "checked='checked'"; ?> />Expedited shipping available<br>
    				Max handling time (days): <input type="number" step="any" id="maxht" name="MaxHandlingTime" size="8" value="<?php echo isset($_GET['MaxHandlingTime']) ? $_GET['MaxHandlingTime']:'' ?>"/>
    			</td>
    		</tr>
    		<tr id="row7">
    			<td class="lable">Sort by:</td>
    			<td class="form">
    			<select id="sortOrder" name="sort">
    				<option <?php if(isset($_GET['sort']) && $_GET['sort'] == 'BestMatch'){ ?> selected <?php };?> value="BestMatch">Best Match</option>
    				<option <?php if(isset($_GET['sort']) && $_GET['sort'] == 'CurrentPriceHighest'){ ?> selected <?php };?> value="CurrentPriceHighest">Price: highest first</option>
    				<option <?php if(isset($_GET['sort']) && $_GET['sort'] == 'PricePlusShippingHighest'){ ?> selected <?php };?> value="PricePlusShippingHighest">Price + Shipping: highest first</option>
    				<option <?php if(isset($_GET['sort']) && $_GET['sort'] == 'PricePlusShippingLowest'){ ?> selected <?php };?> value="PricePlusShippingLowest">Price + Shipping: lowest first</option>
    			</select>
    			</td>
    		</tr>
    		<tr id="row8">
    			<td class="lable">Results Per Page:</td>
    			<td class="form">
    			<select id="perPage" name="perPage">
    				<option <?php if(isset($_GET['perPage']) && $_GET['perPage'] == '5'){ ?> selected <?php };?> value="5">5</option>
    				<option <?php if(isset($_GET['perPage']) && $_GET['perPage'] == '10'){ ?> selected <?php };?> value="10">10</option>
    				<option <?php if(isset($_GET['perPage']) && $_GET['perPage'] == '15'){ ?> selected <?php };?> value="15">15</option>
    				<option <?php if(isset($_GET['perPage']) && $_GET['perPage'] == '20'){ ?> selected <?php };?> value="20">20</option>
    			</select>
    			</td>
    		</tr>
    		<tr id="row9">
                <td></td>
    			<td id="button"><input class="button" type="button" name="clear" value="clear" onclick="Wipe()"> <input id="submit" class="button" type="submit" name="submit" value="search"></td>
    		</tr>
    	</tbody>
        </table>
    	</form>
    	<script type="text/javascript">
    		function Wipe(){
				document.getElementById("keywords").value = "";
				document.getElementById("pricefrom").value = "";
				document.getElementById("priceto").value = "";
				document.getElementById("new").checked = false;
				document.getElementById("used").checked = false;
				document.getElementById("verygood").checked = false;
				document.getElementById("good").checked = false;
				document.getElementById("acceptable").checked = false;
				document.getElementById("fixedprice").checked = false;
				document.getElementById("auction").checked = false;
				document.getElementById("classified").checked = false;
				document.getElementById("raccepted").checked = false;
				document.getElementById("freeship").checked = false;
				document.getElementById("expeditedship").checked = false;
				document.getElementById("maxht").value = "";
				document.getElementById("sortOrder").value = "BestMatch";
				document.getElementById("perPage").value = "5";
				document.getElementById("results").style.display = 'none';
				// var x = 1;
				
    		}
    	</script>
    <?php 
    if(isset($_GET["submit"])){
    	$kcheck = true;
    	$pcheck = true;
    	$mcheck = true;
    	if($_GET["keywords"] == ""){
    		echo "<script type='text/javascript'>alert('Please enter value for Key Words');</script>";
    		$kcheck = false;
    	} 
    	if($kcheck == true && ((isset($_GET["pricefrom"]) && $_GET["pricefrom"] < 0) || (isset($_GET["priceto"]) && $_GET["priceto"] < 0))){
    		echo "<script type='text/javascript'>alert('Price must be 0 or positive number');</script>";
    		$pcheck = false;
    	} 
    	if($kcheck == true && $pcheck == true  && (($_GET["pricefrom"] != "") && ($_GET["priceto"] != "") && $_GET["pricefrom"] > $_GET["priceto"])){
    		echo "<script type='text/javascript'>alert('Minimum price must be equal or less than maximum price, please enter correct price');</script>";
    		$pcheck = false;
    	} 
    	if($kcheck == true && $pcheck == true  && ($_GET['MaxHandlingTime']!="" && preg_match("/^[1-9]\d*$/",$_GET['MaxHandlingTime']) != 1)){
    		echo "<script type='text/javascript'>alert('Max handling time must be positive integer');</script>";
    		$mcheck = false;
    	} 
    	if($kcheck == true && $pcheck == true && $mcheck == true) {
    		$url = "http://svcs.eBay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=xiweiliu-c66b-45c6-bfc2-dd3e100fbfcf&OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML";
    		$url = $url."&keywords=".urlencode($_GET["keywords"]);
    		$url = $url."&sortOrder=".urlencode($_GET["sort"]);
    		$url = $url."&paginationInput.entriesPerPage=".urlencode($_GET["perPage"]); 
    		$counter = 0;   	
    		if($_GET["pricefrom"] != "") {
    			$url = $url."&itemFilter($counter).name=MinPrice&itemFilter($counter).value=".$_GET["pricefrom"];
    			$counter++;
    		}
    		if($_GET["priceto"] != "") {
    			$url = $url."&itemFilter($counter).name=MaxPrice&itemFilter($counter).value=".$_GET["priceto"];
    			$counter++;    			
    		}
    		if(!empty($_GET["condition"])) {
    			$url = $url."&itemFilter($counter).name=Condition";
    			$i = 0;
    			foreach($_GET["condition"] as $cval){
    				$url = $url."&itemFilter($counter).value($i)=$cval";
    				$i++;
    			}
    			$counter++;
    		}
    		if(!empty($_GET["buyformates"])) {
    			$url = $url."&itemFilter($counter).name=ListingType";
    			$i = 0;
    			foreach($_GET['buyformates'] as $bval) {
    				$url = $url."&itemFilter($counter).value($i)=$bval";
    				$i++;
    			}
    			$counter++;
    		}
    		if(isset($_GET["ReturnsAcceptedOnly"])) {
    			$url = $url."&itemFilter($counter).name=ReturnsAcceptedOnly&itemFilter($counter).value=true";
    			$counter++;
    		}
    		if(isset($_GET['freeship'])) {
    			$url = $url."&itemFilter($counter).name=FreeShippingOnly&itemFilter($counter).value=true";
    			$counter++;
    		}
    		if(isset($_GET['expeditedship'])) {
    			$url = $url."&itemFilter($counter).name=ExpeditedShippingType&itemFilter($counter).value=Expedited";
    			$counter++;
    		}
    		if($_GET['MaxHandlingTime'] != "") {
    			$url = $url."&itemFilter($counter).name=MaxHandlingTime&itemFilter($counter).value=".$_GET['MaxHandlingTime'];
    			$counter++;
    		}
    		
    		$xml = simplexml_load_file($url) or die("Error: Cannot create object");
    		#echo "<p>".$url."</p>";
    		echo "<div id='results'>";
    		$total = $xml->paginationOutput->totalEntries;
    		if($total == 0) {
    			echo "<p style='margin-top: 30px; font-size: 40px' align='center'><b>No results found</b></p>";
    		} else {
    			echo "<p style='margin-top: 30px; font-size: 30px' align='center'><b>$total Results for {$_GET['keywords']}</b></p>";
    			echo "<table style='border: 1px solid rgb(216,216,216); margin: 15px auto;'><tbody>";
    			$searchitems = $xml->searchResult;
    			foreach($searchitems->children() as $item){
    					echo "<tr><td rowspan='6' style='border-bottom: 1px solid rgb(216,216,216)'><img src='$item->galleryURL' width='300px' height='300px'></td>";
    					echo "<td height='70px' style='vertical-align: bottom; padding: 0px 15px'><a href='$item->viewItemURL' target='_blank'>$item->title</a></td></tr>";
    					echo "<tr><td style='padding: 0px 15px'><b>Condition:</b>";
    					if($item->condition->conditionId == '1000'){
    						echo " New";
    					}elseif($item->condition->conditionId == '3000'){
    						echo " Used";
    					}elseif($item->condition->conditionId == '4000'){
    						echo " Very Good";
    					}elseif($item->condition->conditionId == '5000'){
    						echo " Good";
    					}elseif($item->condition->conditionId == '6000'){
    						echo " Acceptable";
    					}else{
    						echo " {$item->condition->conditionDisplayName}";
    					}
    					if($item->topRatedListing == 'true'){
    						echo " <img src='itemTopRated.jpg' width='95px' height='95px'>";
    					}
    					echo "</td></tr>";
    					echo "<tr><td style='padding: 0px 15px'>";
    					if($item->listingInfo->listingType == 'FixedPrice' || $item->listingInfo->listingType == 'StoreInventory' ){
    						echo "<b>Buy It Now</b>";
    					}elseif($item->listingInfo->listingType == 'Auction'){
    						echo "<b>Auction</b>";
    					}elseif($item->listingInfo->listingType == 'Classified'){
    						echo "<b>Classified Ad</b>";
    					}
    					echo "</td></tr>";
    					echo "<tr><td style='vertical-align: bottom; padding: 0px 15px'>";
    					if($item->returnsAccepted == 'true'){
    						echo "Seller accepts return";
    					}
    					echo "</td></tr>";
    					echo "<tr><td style='vertical-align: top; padding: 0px 15px'>";
    					if($item->shippingInfo->shippingServiceCost == '0.0'){
    						echo "FREE Shipping -- ";
    					}else{
    						echo "Shipping Not FREE -- ";
    					}
    					if($item->shippingInfo->expeditedShipping == 'true'){
    						echo "Expedited Shipping Available -- ";
    					}
    					echo "Handled for shipping in {$item->shippingInfo->handlingTime} day(s)";
    					echo "</td></tr>";
    					echo "<tr><td style='vertical-align: bottom; border-bottom: 1px solid rgb(216,216,216); padding: 0px 15px'>";
    					echo '<b>Price: $'.$item->sellingStatus->convertedCurrentPrice.'</b>';
    					if($item->shippingInfo->shippingServiceCost != 0.0) {
    						echo '<b> (+ $'.$item->shippingInfo->shippingServiceCost.' for shipping)</b> ';
    					}
    					echo "<i>&nbsp;&nbsp;From $item->location</i>";
    					echo "</td></tr>";
    			}
    			echo "</tbody></table>";
    		}
    		echo "</div>";
    	}
    } 
	?>
    <noscript>
    </body>
</html>
