<?php
global $wpdb;
if (isset($_FILES['file'])){
	if($_FILES['file']['type']==="application/vnd.ms-excel"){
		$count = 1;
		$sql = true;
		$file = $_FILES['file']['tmp_name'];
		$handle = fopen($file,"r");
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
			if($count===1){
				$count++;
			}else{
				$sql = $sql && $wpdb->insert("wp_amail_list", array(
						'id'=>null,
						'name'=>$filesop[0],
						'email'=>$filesop[1],
						'status'=>$filesop[2],
						'verified'=>$filesop[3],
						'url'=>$filesop[4],
						'date_add'=>$filesop[5],
						'address'=>$filesop[6]
					));
			}
		}
	}else{
?>
<p class="bg-danger"> Not a CSV file unfortunately!</p>
<?php
	}
	if($sql){
?>
<p class="bg-primary"> Data is stored successfully in the database!</p>
<?php
	}else{
?>
<p class="bg-danger"> There was a problem with data storage!</p>
<?php
	}
}
?>
<div class="jumbotron">
	<div class="container">
		<p class="fileupload-text">Follow this example of CSV file. <br><a class="btn btn-warning btn-xs" href="<?php echo plugin_dir_url(__FILE__).'example.csv'; ?>">Download CSV file</a></p>
		<form enctype="multipart/form-data" class="centered" action="" id="uploadCSV" method="post">
			<input type="file" name="file" id="file" class="inputfile inputfile-6"/>
					<label for="file">
						<span id='filename'></span> 
						<strong>
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
								<path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
							</svg> Choose a file&hellip;
						</strong>
					</label>
			<p class="hint">Only CSV files accepted.</p>
		</form>
	</div>
</div>

<div class="jumbotron">
	<div class="container">
		<p class="padded">Type in a message to send to the lead active list</p>
		<div class="col-xs-8">
			<?php
				global $wpdb;
				$sql = $wpdb->get_results("SELECT * FROM wp_amail_msg");
				$sql = $sql[0];
			?>
			<form class="form-group" method="post">
				<textarea class="form-control" cols="75" rows="10" id="txtMessage" name="txtMessage"><?php echo $sql->msg; ?></textarea>
				<input class="btn btn-primary pull-right" type="submit" value="Send Message"/>
			</form>
		</div>
		<div class="col-xs-4">
			<h4>Tags (Click to input)</h4>
			<ul id="ClickWordList">
				<li>[{name}]</li>
				<li>[{email}]</li>
				<li>[{url}]</li>
				<li>[{date}]</li>
			</ul>
		</div>
		
	</div>
</div>
<?php
global $wpdb;
$sql = $wpdb->get_results("SELECT * FROM wp_amail_msg");
if($sql){
	if(isset($_POST['txtMessage'])){
		$sql = $wpdb->update("wp_amail_msg",array(
			"msg"=>$_POST['txtMessage']
			),
		array(
			"id"=>1
			));
	}
}else{
	if(isset($_POST['txtMessage'])){
		$sql = $wpdb->insert("wp_amail_msg", array(
			'id'=>1,
			'msg'=>$_POST['txtMessage'],
		));
	}
}
if(isset($_POST['txtMessage'])){
	$msg = $_POST['txtMessage'];
	send_messages($msg);
}
function send_messages($msg){
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM wp_amail_list WHERE status='active'");
	$patterns = array("[{name}]","[{email}]","[{url}]","[{date}]");
	foreach($results as $result){
		$replacemenets = array($result->name,$result->email,$result->url,$result->date_add);
		$msg_replaced = preg_replace($patter, $replacemenets, $msg);
		@mail($result->email,"Contact",$msg_replaced);
	}
}
?>