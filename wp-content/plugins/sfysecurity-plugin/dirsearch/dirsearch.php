<?php
	require_once 'helper.php';
?>	
<html>
	<head>
		<script language="JavaScript">
			<!--
				function addData(event,id,parentfieldid){
					val_id = "cn_data_" + id;
					//get the value of currern row
					var val = document.getElementById(val_id).innerHTML;
					val = val.trim();
					var parentfield = parentfieldid;
					var parentfieldvalue = parent.document.getElementById(parentfield).value;
					if(parentfieldvalue == ''){
						parentfieldvalue += val;
					}else{
						parentfieldvalue += ',' + val;
					}
					//set value to parent text field
					parent.document.getElementById(parentfield).value = parentfieldvalue;
					//alert("here " + val + parentfield );
					event.returnValue = false;
					event.preventDefault();
				}
				
				String.prototype.trim = function(){
					return this.replace(/^\s+/,'').replace(/\s+$/,'');
				}
			-->
		</script>
	</head>
	<body>
		<?php
			$parentfieldid = '';
			if(isset($_GET['fieldid'])){
				$parentfieldid = $_GET['fieldid'];
			}
		?>
	<form method="post">
		<table width="500px" style="font-family: Verdana,Geneva,sans-serif;font-size:x-small;background-color:#D9E6F7;border:1px solid #B1CFE9;">
			<tbody>
				<tr>
					<td nowrap='nowrap'>
						Search for: <input type="text" name="search"  style="font-family: Verdana,Geneva,sans-serif;font-size:x-small;"/>
						<input type="radio" name="criteria" value="all" checked> All </input>
						<input type="radio" name="criteria" value="group"> Group </input>
						<input type="radio" name="criteria" value="person"> Person </input>
						<input type="submit" value="Search Directory" style="font-family: Verdana,Geneva,sans-serif;font-size:x-small;"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	
	<table width="500px" cellspacing="0" cellpadding="0" border="0" style="font-family: Verdana,Geneva,sans-serif;font-size:x-small;margin-top:0em;margin-bottom:.3em;">
		<tbody>
			<tr>
				<?php				
					if(isset($_POST['search'])) : 
						$search = $_POST['search'];
						$criteria = $_POST['criteria'];
						$ldap_data = pull_data_from_ad($search,20,$criteria);
						//print_r($ldap_data);
						//die;
						
						$i = 0;
						if(count($ldap_data) > 0) :
							?>
							<td valign="top" nowrap="nowrap" style="padding-left:5px">
							<strong>Results:</strong>
							</td>
							<td width="100%">
							<br/>
							<table width="475px" style="font-family: Verdana,Geneva,sans-serif;font-size:x-small;margin-top:-1px;margin-bottom:.3em;" bgcolor="#D9E6F7">
								<tbody>
									<tr>
										<td width="200px" align="center">
											<strong>CN</strong>
										</td>
										<td width="200px" align="center">
											<strong>Display Name</strong>
										</td>
										<td width="50px" align="center">
											<strong>&nbsp;&nbsp;</strong>
										</td>
								</tbody>
							</table>
							<?php
							foreach ($ldap_data as $data) : 
								$bg_color = ($i % 2 == 0 ? '#FFFFFF' : '#D7D7D7');
								$i = $i + 1;
							?>
							<table width="475px" style="font-family: Verdana,Geneva,sans-serif;font-size:x-small;margin-top:-1px;margin-bottom:.3em;" bgcolor="<?php echo $bg_color;?>">
								<tbody>
									<tr>
										<td width="25px" align="left">
											<img src="<?php echo $data->type . '.JPG'; ?>"/>
										</td>
										<td width="200px" align="left" id="cn_data_<?php echo $i; ?>" >
											<?php echo trim($data->cn);?>
										</td>
										<td width="200px" align="left">
											<?php echo trim($data->display_name); ?>
										</td>
										<td width="50px" align="right">
											<a href="#" onclick="addData(event, <?php echo $i; ?>, '<?php echo $parentfieldid; ?>');">Add</a>
										</td>
								</tbody>
							</table>
							<hr width="475px" noshade="" align="left">
							<br>
							<?php
							endforeach;
							echo '</td>';
						else:
						?>
							<td width="25px" valign="top" nowrap="nowrap" style="padding-left:5px">
							<strong>Results:</strong>
							</td>
							<td>&nbsp;&nbsp;No results found.</td>
						<?php
						endif;
					endif;
				?>
				</td>
			</tr>
		</tbody>
	</table>
	</body>
</html> 