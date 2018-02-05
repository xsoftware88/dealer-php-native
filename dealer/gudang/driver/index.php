<?php

include __DIR__ . "/../head.php";
include __DIR__ . "/../menu.php";

		$user = $_SESSION['username'];

		$statement = "SELECT * 
			FROM sales_unit_kirim 
			WHERE approve_adm=1
            AND NOT driver='Tanpa Driver'
			ORDER BY jam_kirim ASC,range_area ASC";
		$stmt = $conn->prepare($statement);
		$stmt->execute();
?>

<style>
	table {
		font-size: 15px;
		table-layout: fixed;
		word-wrap: break-word;
	}
.table-bordered {
    width:50em;
}
	.edit {width: 60px;}
</style>
	<table class="table table-bordered">
		<?php 
		if($stmt->rowCount() > 0) {
		$data = $stmt->fetchAll();
		$i=1;
		foreach ($data as $val) {
		?>
		
		<tbody>
			<tr>
			<td>
            <?php
            if(($val['driver'] != $user) && ($val['approve_driver'] == 0)) {
            ?>
            <a href="edit.php?id=<?php echo $val['id'];?>"><?php echo 'MOBIL SIAP No : ' . $i; ?></a>
            <?php
            } else { ?>
            <?php echo 'MOBIL SIAP No : ' . $i; ?>
            <?php } ?>
            </td>
			<td class="edit">
			<?php
            $i++;
// icon approval
			if (empty($_SESSION['username']) && ($val['approve_driver'] == 1)) { ?>
				<input type="submit" class="btn btn-success" value="">
			 <?php } elseif (!empty($_SESSION['username']) && ($val['approve_driver'] == 1)) { ?>
			 	<input type="submit" class="btn btn-success" value="">
			 <?php } else { ?>
				<input type="submit" class="btn btn-danger" value="">
			<?php } ?>
			</td>
		</tr>
		</tbody>
<?php
		}
	}
?>
	</table>