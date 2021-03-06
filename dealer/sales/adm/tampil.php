<?php
session_start();

	include __DIR__ . '/../../login/head.php';

	if (!empty($_SESSION['username']) && $modul == 'admin')
	{
		$user = $_SESSION['username'];
        $cabang = $_SESSION['cabang'];

		$statement = "SELECT * 
			FROM sales_unit_kirim
            WHERE cabang='".$cabang."'
            AND month(tgl_simpan)=month(now())
            AND year(tgl_simpan)=year(now())
			ORDER BY jam_kirim ASC";

		$stmt = $conn->prepare($statement);
		$stmt->execute();
	} else {
			echo "<script type='text/javascript'>
                    window.location = '../../login/login-form.php';
                </script>";
	}
?>

<style>
	table {
		font-size: 12px;
		table-layout: fixed;
		word-wrap: break-word;
	}
	.jam{width:100px;}
	.edit {width: 30px;}
	.pdc {width: 100px;}
	.driver {width: 100px;}
	.spv {width: 60px;}
	.telp{width: 100px;}
	.kota{width: 70px;}
	.noka{width: 140px;}
	.spk{width: 100px;}
	.bast{width: 50px;}
</style>
<div class="container-fluid">
	
<form id="formCari" class="form-inline" action="" method="POST">
    <!-- Select Basic -->
    <div class="control-group">
	    <label class="control-label" for="tanggal">Mulai dari :</label>
	    <input type="text" class="dtpick" id="tanggal" name="mulai">
	    <label class="control-label" for="tanggal">Sampai :</label>
	    <input type="text" class="dtpick" id="tanggal" name="sampai">
	    <input type="submit" class="btn btn-primary" name ="cariData" value="Cari">
    	<input type="text" id="search" class="input-medium search-query pull-right" name="search" placeholder="search di sini" />
  	</div>
</form>
 
<?php 
if (!$_POST) {
	// tanpa search
?>

	<table class="table table-bordered" id="result">
		<thead>
		<tr>
			<th class="jam">Jam Pengiriman</th>
			<th class="pdc">PDC</th>
			<th class="driver">Driver</th>
			<th class="spk">SPK</th>
			<th class="kota">Kota</th>
			<th class="spv">SPV</th>
			<th class="noka">Noka</th>
			<th class="tipe">Type/Warna</th>
			<th class="variasi">Variasi</th>
			<th class="edit"></th>
		</tr>
		</thead>
		
		<?php 
		if($stmt->rowCount() > 0) {
		$data = $stmt->fetchAll();

		foreach ($data as $val) {
		?>
		
		<tbody>
			<tr>

			<?php
			$time = strtotime($val['jam_kirim']);
			$newTime = date('d-m-Y H:i', $time);
        	
        	if(!empty($val['jam_kirim'])) {
			?>

			<td><?php echo $newTime; ?></td>
            <?php } else { ?>
            <td><?php echo $val['jam_kirim']; ?></td>
            <?php } ?>
            
			<td>
			<?php
// icon approval pdc
			if (empty($_SESSION['username']) && $val['approve_pdc'] == 1) { ?>
				<input type="submit" class="btn btn-success" value="">
				<?php echo $val['pdc'] ;?>
			 <?php } elseif (!empty($_SESSION['username']) && $val['approve_pdc'] == 1){ ?>
			 	<input type="submit" class="btn btn-success" value="">
			 	<?php echo $val['pdc'] ;?>
			 <?php }else { ?>
				<input type="submit" class="btn btn-danger" value="">
			<?php } ?>
			</td>
			<td>
			<?php
// icon approval driver
			if (empty($_SESSION['username']) && $val['approve_driver'] == 1) { ?>
				<input type="submit" class="btn btn-success" value="">
				<?php echo $val['driver'] ;?>
			 <?php } elseif (!empty($_SESSION['username']) && $val['approve_driver'] == 1){ ?>
			 	<input type="submit" class="btn btn-success" value="">
			 	<?php echo $val['driver'] ;?>
			 <?php }else { ?>
				<input type="submit" class="btn btn-danger" value="">
			<?php } ?>
			</td>
			<?php
// edit
			if (isset($_SESSION['username']) && $_SESSION['username'] == ($modul == 'admin')) { ?>
			<td>
			<a href="edit.php?id=<?php echo $val['id'];?>">
			
			<?php echo $val['nomor_spk']; ?>
			</a>
			</td>

			<?php
			} else { 
			?>
			<td><?php echo $val['nomor_spk']; ?></td> 
			
			<?php 
			}
			?>
			<td><?php echo $val['kota_cust']; ?></td>
			<td><?php echo $val['spv']; ?></td>
			<td><?php echo $val['noka']; ?></td>
			<td><?php echo $val['type_unit']; ?><br><?php echo $val['warna_unit']; ?></td>
			<td><?php echo strtoupper($val['variasi']); ?></td>
			<td>
			<?php 
// icon approval
			if  (empty($_SESSION['username']) && $val['approve_adm'] == 1) {
				echo "<i class='icon-ok'></i>";
			} elseif (!empty($_SESSION['username']) && $val['approve_adm'] == 1) {
				echo "<i class='icon-ok'></i>";
			 } else {
				echo "<i class='icon-remove'></i>";
			} 
			?>
			</td>
		</tr>
		</tbody>
<?php
		}
	}
?>
	</table>
	
	<?php } elseif (isset($_POST)) {
	 if (!empty($_POST['mulai']) && !empty($_POST['sampai'])) {
// untuk search
		
		$mulai = $_POST['mulai'] . ' 00:00:00';
		$sampai = $_POST['sampai'] . ' 23:59:59';

		if (empty($_SESSION['username'])) {
				$searchStmt = "SELECT * 
				FROM sales_unit_kirim 
				WHERE cabang='".$cabang."' 
                AND jam_kirim < '".$sampai."' 
				AND jam_kirim > '".$mulai."' 
				ORDER BY jam_kirim ASC";
		} elseif (!empty($_SESSION['username']) && $_SESSION['username'] == ($modul == 'admin')) {
				$searchStmt = "SELECT * 
					FROM sales_unit_kirim 
					WHERE cabang='".$cabang."' 
                    AND jam_kirim < '".$sampai."' 
					AND jam_kirim > '".$mulai."' 
					ORDER BY jam_kirim ASC";
		}

		$search = $conn->prepare($searchStmt);
		$search->execute();
		?>

		<table class="table table-bordered" id="result">
		<thead>
		<tr>
			<th class="jam">Jam Pengiriman</th>
			<th class="pdc">PDC</th>
			<th class="driver">Driver</th>
			<th class="spk">SPK</th>
			<th class="kota">Kota</th>
			<th class="spv">SPV</th>
			<th class="noka">Noka</th>
			<th class="tipe">Type/Warna</th>
			<th class="variasi">Variasi</th>
			<th class="edit"></th>
		</tr>
		</thead>
		
		<?php 
		if($search->rowCount() > 0) {
		$data = $search->fetchAll();

		foreach ($data as $val) {
		?>
		
		<tbody>
			<tr>
			
			<?php
			$time = strtotime($val['jam_kirim']);
			$newTime = date('d-m-Y H:i', $time);
			
			if(!empty($val['jam_kirim'])) {
			
			?>

			<td><?php echo $newTime; ?></td>
            <?php } else { ?>
            <td><?php echo $val['jam_kirim']; ?></td>
            <?php } ?>
            
			<td>
			<?php
// icon approval pdc
			if (empty($_SESSION['username']) && $val['approve_pdc'] == 1) { ?>
				<input type="submit" class="btn btn-success" value="">
				<?php echo $val['pdc'] ;?>
			 <?php } elseif (!empty($_SESSION['username']) && $val['approve_pdc'] == 1){ ?>
			 	<input type="submit" class="btn btn-success" value="">
			 	<?php echo $val['pdc'] ;?>
			 <?php }else { ?>
				<input type="submit" class="btn btn-danger" value="">
			<?php } ?>
			</td>
			<td>
			<?php
// icon approval driver
			if (empty($_SESSION['username']) && $val['approve_driver'] == 1) { ?>
				<input type="submit" class="btn btn-success" value="">
				<?php echo $val['driver'] ;?>
			 <?php } elseif (!empty($_SESSION['username']) && $val['approve_driver'] == 1){ ?>
			 	<input type="submit" class="btn btn-success" value="">
			 	<?php echo $val['driver'] ;?>
			 <?php }else { ?>
				<input type="submit" class="btn btn-danger" value="">
			<?php } ?>
			</td>
			<?php
			if (isset($_SESSION['username']) && $_SESSION['username'] == ($modul == 'admin')) { ?>
			<td>
			<a href="edit.php?id=<?php echo $val['id'];?>">
			
			<?php echo $val['nomor_spk']; ?>
			</a>
			</td>
			<?php } else { ?>
			<td><?php echo $val['nomor_spk']; ?></td> 
			<?php }
			?>
			<td><?php echo $val['kota_cust']; ?></td>
			<td><?php echo $val['spv']; ?></td>
			<td><?php echo $val['noka']; ?></td>
			<td><?php echo $val['type_unit']; ?><br><?php echo $val['warna_unit']; ?></td>
			<td><?php echo strtoupper($val['variasi']); ?></td>
			<td>
			<?php 
// icon approval
			if  (empty($_SESSION['username']) && $val['approve_adm'] == 1) {
				echo "<i class='icon-ok'></i>";
			} elseif (!empty($_SESSION['username']) && $val['approve_adm'] == 1) {
				echo "<i class='icon-ok'></i>";
			 } else {
				echo "<i class='icon-remove'></i>";
			} 
			?>
			</td>
		</tr>
		</tbody>
<?php
		}
	}
?>
	</table>
	
	<?php
}
}
	?>

</div>
<script type="text/javascript">
    $(function(){
        $(".dtpicker").appendDtpicker({
            "closeOnSelected": true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
    $(function(){
        $(".dtpick").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly" : true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
	
      $(document).ready(function(){  
           $('#search').keyup(function(){  
                search_table($(this).val());  
           });  
           function search_table(value){  
                $('#result tr').each(function(){  
                     var found = 'false';  
                     $(this).each(function(){  
                          if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
                          {  
                               found = 'true';  
                          }  
                     });  
                     if(found == 'true')  
                     {  
                          $(this).show();  
                     }  
                     else  
                     {  
                          $(this).hide();  
                     }  
                });  
           }  
      });  

</script>
