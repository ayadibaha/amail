<?php
global $wpdb;
$sql = "SELECT * FROM wp_amail_list";
$results = $wpdb->get_results($sql);
?>
<table id="leadList">
	<thead>
		<th>#</th>
		<th>Name</th>
		<th>Email</th>
		<th>Status</th>
		<th>Verif.</th>
		<th>Url</th>
		<th>Date of sub</th>
		<th>Address</th>
	</thead>
	<tbody>
		<?php
			foreach($results as $result){
		?>
		<tr>
			<td><?php echo $result->id; ?></td>
			<td><?php echo $result->name; ?></td>
			<td><?php echo $result->email; ?></td>
			<td><?php echo $result->status; ?></td>
			<td><?php echo $result->verified; ?></td>
			<td><?php echo $result->url; ?></td>
			<td><?php echo $result->date_add; ?></td>
			<td><?php echo $result->address; ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>