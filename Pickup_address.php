<?php 
$shop_url =$_REQUEST['shop'];
require __DIR__.'/connection.php'; //DB connectivity
echo '<div class="pickupadreess">';
$pickup_address = pg_query($dbconn4, "SELECT * FROM pickup_address WHERE shop_url = '{$shop_url}'");
	if(pg_num_rows($pickup_address)){
		$i=1;
		
		while ($row = pg_fetch_assoc($pickup_address)) {?>
		<div class='formmain'>
			<h3>Pickup Address <?php echo $i; ?></h3>
  <form action="" method="POST" id="form_<?php echo $i; ?>">
    <input name="saveaddress" type="hidden" value="<?php echo $i; ?>"><input type="hidden" name="shop_url" value="<?php echo $shop_url; ?>">
    <input type="text" name="username" placeholder="Name" value="<?php echo $row['name']?>" required>
    <input value="<?php echo $row['address_line1']?>" type="textarea" name="address_line1" placeholder="Adrress 1" required max="60">
    <input  value="<?php echo $row['address_line2']?>" type="textarea" name="address_line2" placeholder="Adrress 2"  max="60">
	<input value="<?php echo $row['city']?>" type="text" name="city" placeholder="City" required>
    <input value="<?php echo $row['zipcode']?>" type="text" name="zipcode" placeholder="Zip Code" required>
    <input value="<?php echo $row['phoneno']?>" type="text" name="phoneno" placeholder="Phone no" required>
    <input value="Save Address" type="button" id="<?php echo $i ?>" class="savebtn" name="saveaddress" value="Save Address">
			</form></div>
		<?php
		$i++;
		}
	}
	
	?>
		<div class="addnewaddress"></div>
  
	<br/>
	<input type="button" id="add_new_address" value="Add New Address" /><br/> 
</div>
<script>
$("#add_new_address").click(function() {
var address_id = parseInt($('body .formmain').length+1);	
	var planDiv = '<div class="formmain"><h3>Pickup Address '+address_id+'</h3> <form action="" method="POST" id="form_'+address_id+'"><input type="hidden" name="shop_url" value="<?php echo $shop_url; ?>"><input type="hidden" value="'+address_id+'" name="saveaddress" ><input type="text" placeholder="Name" name="username" value="" required><textarea name="address_line1"  required max="60" placeholder="Address 1"></textarea><textarea name="address_line2"  max="60" placeholder="Adrress 2"></textarea><input type="text" name="city" value="" required placeholder="city"><input type="text" name="zipcode" placeholder="Zip Code" value="" required><input type="text" name="phoneno" placeholder="Phone No" value="" required> <input type="button" name="saveaddress"  id="'+address_id+'" class="savebtn" value="Save Address"></form></div>'; 
		$("div[class^=addnewaddress]:last").after(planDiv);
	});

	$('body').on('click', '.savebtn', function(e) {
	   e.preventDefault();
	   var get_id = $(this).attr('id');
	   alert($("body #form_"+get_id+"input[name=username]").val());
		if(($("body #form_"+get_id+"input[name=username]").val()!='') && ($("body #form_"+get_id+"input[name=address_line1]").val()!='')&& ($("body #form_"+get_id+"input[name=address_line2]").val()!='')&& ($("body #form_"+get_id+"input[name=city]").val()!='')&& ($("body #form_"+get_id+"input[name=zipcode]").val()!='')&& ($("body #form_"+get_id+"input[name=phoneno1]").val()!='')){
		
		var formdata = $('body #form_'+get_id).serialize();
		$.ajax({
			type: 'POST',
			url: '/checklogin.php',
			data: formdata,
			success: function(resp){
	        	alert(resp);		
			}
		});
		}
		else{
		alert("Please fill the all fields");	
		}
	});
</script>

