<form action="" method="get" class="form-horizontal well no-print">
	<div class="form-group">
		<label class="control-label col-sm-3">
			Tampilkan Data			
		</label>
		<div class="col-sm-9">
			<label for="show1" class="block">
				<input type="radio" id="show1" <?php if(isset($_GET['show'])){if($_GET['show'] == 1){echo "checked";}}?> name="show" value="1" onchange="this.form.submit()">
				Master Inventory
			</label>
			<label for="show2" class="block">
				<input type="radio" id="show2" <?php if(isset($_GET['show'])){if($_GET['show'] == 2){echo "checked";}}?> name="show" value="2" onchange="this.form.submit()">
				Distribution ke
			</label>
		</div>
	</div>
	<?php
	if(isset($_GET['show'])){
		if($_GET['show'] == 2){
	?>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Filter Tempat
		</label>
		<div class="col-sm-9">
			<select name="filter" name="Tempat" class="form-control" onchange="this.form.submit()">
				<option value="">- Seluruh Perusahaan -</option>
				<?php
				foreach($listdiv as $iddv=>$dvname){
					$sel = "";
					if(isset($_GET['filter'])){
						if($_GET['filter'] == $iddv){
							$sel = "selected";
						}
					}
					echo "
					<option $sel value='$iddv'>$dvname</option>";
				}
				?>
			</select>
		</div>
	</div>
	<?php
		}
	}
	?>

	<div class="form-group">
		<label class="control-label col-sm-3">
			
		</label>
		<div class="col-sm-9">
			<label for="dtl">
				<input type="checkbox" name="dtl" id="dtl" value="1" onchange="this.form.submit()" <?php if(isset($_GET['dtl'])){if($_GET['dtl'] == 1){echo "checked";}}?>> Tampilkan Dalam Mode Detail
			</label>
		</div>
	</div>

</form>


<div class="print-area">

<?php
if(isset($show)):
echo "
	<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'><span class='fa fa-print fa-fw'></span> Print</a>
";

if($show == 1) :
?>

	<table class="data table">
		<thead>
			<tr>
				<th>#</th>
				<th>Nama Item</th>
				<th>Tanggal</th>
				<th>Masuk</th>
				<th>Keluar</th>
				<?php
				if(isset($_GET['dtl'])){
					echo "<th>Keterangan</th>";
				}
				else{
					echo "<th>Stok Akhir</th>";
				}
				?>
			</tr>			
		</thead>
		<tbody>
		<?php
		if(isset($query)){
			$n = 1;
			foreach($query as $idmaster=>$isi){
				if(isset($list_cc[$idmaster])){

					$nama   = $list_cc[$idmaster][0];
					$harga = $list_cc[$idmaster][1];
					$mutasi = 0;
					$masuk = $keluar = 0;
					foreach($isi as $tgl => $row){
						$date = date("Y-m-d",$tgl);

						$terima = "";
						if(isset($row['terima'])){
							$terima = $row['terima'];
							$mutasi += $terima;
						}
						$kirim = 0;
						if(isset($row['kirim'])){
							$kirim = $row['kirim'];
							$mutasi -= $kirim;
						}

						$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";


						if($detail == 1){
							echo "
							<tr>
							<td>$n</td>
							<td>$nama</td>
								<td>".indo_date($date,"half")."</td>
								<td>$terima</td>
								<td>$kirim</td>
								<td>$ket</td>
								
							</tr>
							";
							$n++;
						}
						else{
							$masuk += intval($terima);
							$keluar += intval($kirim);
						}
					}

					if($detail == 1){
						echo "
						<tr class='active'>
							<td colspan=4 align='right'>Stok Akhir</td>
							<td><strong>$mutasi</strong></td>
							<td></td>
						</tr>
						<tr>
							<td colspan=6></td>
						</tr>
						";
					}
					else{
						echo "
						<tr>
							<td>$n</td>
							<td>$nama</td>
							<td>".indo_date($date,"half")."</td>
							<td>$masuk</td>
							<td>$keluar</td>
							<td><strong>$mutasi</strong></td>
						</tr>
						";
						$n++;
					}
				}
			}
		}
		?>
		</tbody>
	</table>

<?php
elseif($show == 2):
?>

	<table class="data table">
		<thead>
			<tr>
				<th>#</th>
				<th>Tempat</th>
				<th>Tanggal</th>
				<th>Nama Barang</th>
				<th>Terjual</th>
				<th>Harga Barang</th>
				
			</tr>
		</thead>
		<tbody>
		<?php
		if(isset($query)){
			$n = 1;
			foreach($query as $idTempat=>$isi){
				if(isset($listdiv[$idTempat])){

					$Tempat = $listdiv[$idTempat];

					foreach($isi as $idmaster => $isis){
						$ccname = isset($list_cc[$idmaster][0]) ? $list_cc[$idmaster][0] : null;
						$ccharga = isset($list_cc[$idmaster][1]) ? $list_cc[$idmaster][1] : null;
						$mutasi = 0;
						$masuk = $keluar = 0;
						
						foreach($isis as $tgl => $row){
							$date = date("Y-m-d",$tgl);

							$kirim = "";
							if(isset($row['kirim'])){
								$kirim = $row['kirim'];
								$mutasi += $kirim;
							}
							$jual = "";
							if(isset($row['jual'])){
								$jual = $row['jual'];
								$mutasi -= $jual;
							}

							$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";


							if($detail == 1){
								echo "
								<tr>
									<td>$n</td>
									<td>$Tempat</td>
									<td>".indo_date($date,"half")."</td>
									<td>$ccname</td>
									<td>$kirim</td>
									<td>$ccharga</td>
									
									
								</tr>
								";
								$n++;
							}
							else{
								$masuk += intval($kirim);
								$keluar += intval($jual);
							}
						}

						if($detail == 1){
							$intccharga = (int)$ccharga;
							$intkirim = (int)$kirim;
							$total = $intccharga * $intkirim;
							echo "
							<tr class='active'>
								<td colspan=5 align='right'>Total</td>
								<td><strong>Rp. $total</strong></td>
								<td></td>
							</tr>
							<tr>
								<td colspan=7></td>
							</tr>
							";
						}
						else{
							echo "
							<tr>
								<td>$n</td>
								<td>$Tempat</td>
								<td>".indo_date($date,"half")."</td>
								<td>$ccname</td>
								<td>$masuk</td>
								<td>$ccharga</td>
								
							</tr>
							";
							$n++;
						}




					}


				}
			}
		}
		?>
		</tbody>
	</table>

<?php
endif;
echo "
	<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'><span class='fa fa-print fa-fw'></span> Print</a>
";
endif;
?>

</div>
