<?php 

	if (isset($_GET['admin-edit'])) {
		$id 		=	$_GET['admin-edit'];

		if (isset($_POST['admin-update'])) {







$namafolder="foto/"; //tempat menyimpan file
if (!empty($_FILES["file"]["tmp_name"]))
{
    $jenis_gambar=$_FILES['file']['type'];
    

    if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" ||$jenis_gambar=="image/x-png")
    {          
        $gambar = $namafolder . basename($_FILES['file']['name']);      
        if (move_uploaded_file($_FILES['file']['tmp_name'], $gambar)) {
  			$nama 		=	$_POST['nama'];
			$username	=	$_POST['username'];
			$email 		=	$_POST['email'];
			$telp 		=	$_POST['telp'];
			$alamat 	=	$_POST['alamat'];
			$gambar =

			$admin 		=	mysql_query("UPDATE users 
										SET `users_nama` = '$nama', `users_username` = '$username', 
										`users_telp` = '$telp', `users_alamat` = '$alamat', `users_email` = '$email', `users_foto` = '$gambar'
										WHERE users_id = '$id'");
}
			if ($admin) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?users=user'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?users=user'>";
			}	
		}
}
}
	$dataadmin 		=	mysql_query("SELECT * FROM users WHERE users_id='$id'");
	$row			=	mysql_fetch_assoc($dataadmin);
	
}
?>

<?php 

	if ( isset( $_GET['guru-edit'] ) ) {
		$id= $_GET['guru-edit'];
		if ( isset( $_POST['guru-update'] ) ) {
			$sql= ("
				SELECT *
				FROM users
				WHERE users_username='{$_POST['username']}'
					AND users_id != '{$id}'
			");

			if ( count(query_result($connect, $sql)['fetch_assoc']) > 0 ) {
				echo "<script>alert('Maaf username sudah digunakan'); window.history.back();</script>";

			} else {
				if ( !empty($_FILES['gambar']['tmp_name']) ) {
					$sql= ("
						SELECT *,
							CASE
								WHEN users.users_foto IS NULL THEN 'no_image.png'
								WHEN users.users_foto='' THEN 'no_image.png'
								ELSE users.users_foto
							END AS users_foto_mod 
						FROM users
						WHERE 1=1
							AND users_id = '{$id}'
					");
					$row= query_result($connect, $sql)['fetch_assoc'][0];
					if ( $row['users_foto_mod'] !='no_image.png' ) {
						if(file_exists('./img/' .$row['users_foto_mod'])){
							unlink('./img/' .$row['users_foto_mod']);
						}
					}
					$imageFileType= ['jpg','jpeg','png'];
					if ( in_array(pathinfo(basename($_FILES["gambar"]["name"]),PATHINFO_EXTENSION), $imageFileType) ) {
						$users_foto= img_resize($files=$_FILES["gambar"],$maxDim=250,$path_destination='./img/');
					}else {
						echo "<script>alert('Sorry, only JPG, JPEG & PNG files are allowed'); window.history.back();</script>";
					}
				}
				

				if( empty($_POST['password']) ){ # jika password kosong
					$sql= ("
						UPDATE
							users
						SET
							`users_noinduk` = '{$_POST['noinduk']}',
							`users_nama` = '{$_POST['nama']}',
							`users_username` = '{$_POST['username']}',
							`users_telp` = '{$_POST['telp']}',
							`users_alamat` = '{$_POST['alamat']}',
							".(!empty($users_foto)? "`users_foto`='{$users_foto}',": NULL)."
							`users_email` = '{$_POST['email']}'
						WHERE users_id = '{$id}'
					");
	
				}else { # jika password terisi
					$sql= ("
						UPDATE
							users
						SET
							`users_noinduk` = '{$_POST['noinduk']}',
							`users_nama` = '{$_POST['nama']}',
							`users_username` = '{$_POST['username']}',
							`users_password` = '".md5($_POST['password'])."',
							`users_telp` = '{$_POST['telp']}',
							`users_alamat` = '{$_POST['alamat']}',
							".(!empty($users_foto)? "`users_foto`='{$users_foto}',": NULL)."
							`users_email` = '{$_POST['email']}'
						WHERE users_id = '{$id}'
					");
				}
				$query= mysql_query($sql);
				if ( $query ) {
					echo "<script>alert('Data berhasil diubah'); window.history.go(-2);</script>";
				} else {
					echo "<script>alert('Maaf data gagal diubah'); window.history.back();</script>";
				}
				

			}		
		}

		$dataguru = mysql_query("SELECT *,
			CASE
				WHEN users.users_foto IS NULL THEN 'no_image.png'
				WHEN users.users_foto='' THEN 'no_image.png'
				ELSE users.users_foto
			END AS users_foto_mod 
		FROM users WHERE users_id='{$id}'");
		$row = mysql_fetch_assoc($dataguru);
	}
?>

<?php 

	if (isset($_GET['siswa-edit'])) {
		$id = $_GET['siswa-edit'];
		if (isset($_POST['siswa-update'])) {
			$sql= ("
				SELECT * 
				FROM users
				WHERE users_username='{$_POST['username']}'
					AND users_id != '{$id}'
			");

			if ( count(query_result($connect, $sql)['fetch_assoc']) > 0 ) {
				echo "<script>alert('Maaf username sudah digunakan'); window.history.back();</script>";

			} else {
				if ( !empty($_FILES['gambar']['tmp_name']) ) {
					$sql= ("
						SELECT *,
							CASE
								WHEN users.users_foto IS NULL THEN 'no_image.png'
								WHEN users.users_foto='' THEN 'no_image.png'
								ELSE users.users_foto
							END AS users_foto_mod 
						FROM users
						WHERE 1=1
							AND users_id = '{$id}'
					");
					$row= query_result($connect, $sql)['fetch_assoc'][0];
					if ( $row['users_foto_mod'] !='no_image.png' ) {
						if(file_exists('./img/' .$row['users_foto_mod'])){
							unlink('./img/' .$row['users_foto_mod']);
						}
					}
					$imageFileType= ['jpg','jpeg','png'];
					if ( in_array(pathinfo(basename($_FILES["gambar"]["name"]),PATHINFO_EXTENSION), $imageFileType) ) {
						$users_foto= img_resize($files=$_FILES["gambar"],$maxDim=250,$path_destination='./img/');
					}else {
						echo "<script>alert('Sorry, only JPG, JPEG & PNG files are allowed'); window.history.back();</script>";
					}
				}

				if( empty($_POST['password']) ){ # jika password kosong
					$sql= ("
						UPDATE
							users
						SET
							`users_noinduk` = '{$_POST['noinduk']}',
							`users_nama` = '{$_POST['nama']}',
							`users_username` = '{$_POST['username']}',
							`users_telp` = '{$_POST['telp']}',
							`users_alamat` = '{$_POST['alamat']}',
							`users_email` = '{$_POST['email']}',
							".(!empty($users_foto)? "`users_foto`='{$users_foto}',": NULL)."
							`users_status` = '{$_POST['status']}'
						WHERE users_id = '{$id}'
					");
	
				}else { # jika password terisi
					$sql= ("
						UPDATE
							users
						SET
							`users_noinduk` = '{$_POST['noinduk']}',
							`users_nama` = '{$_POST['nama']}',
							`users_username` = '{$_POST['username']}',
							`users_password` = '".md5($_POST['password'])."',
							`users_telp` = '{$_POST['telp']}',
							`users_alamat` = '{$_POST['alamat']}',
							`users_email` = '{$_POST['email']}',
							".(!empty($users_foto)? "`users_foto`='{$users_foto}',": NULL)."
							`users_status` = '{$_POST['status']}'
						WHERE users_id = '{$id}'
					");
				}

				$query= mysql_query($sql);
				if ( $query ) {
					echo "<script>alert('Data berhasil diubah'); window.history.go(-2);</script>";
				} else {
					echo "<script>alert('Maaf data gagal diubah'); window.history.back();</script>";
				}
				
			}
		}

		$datasiswa = mysql_query("SELECT *,
		CASE
			WHEN users.users_foto IS NULL THEN 'no_image.png'
			WHEN users.users_foto='' THEN 'no_image.png'
			ELSE users.users_foto
		END AS users_foto_mod
		FROM users WHERE users_id='{$id}'");
		$row = mysql_fetch_assoc($datasiswa);
	}
?>

<?php 

	if (isset($_GET['kelas-edit'])) {
		$id 		=	$_GET['kelas-edit'];

		if (isset($_POST['kelas-update'])) {
			$nama 		=	$_POST['nama'];
			$wali 		=	$_POST['wali'];

			$kelas 		=	mysql_query("UPDATE kelas 
										SET 'kelas_nama' = '$nama', `users_id` = '$wali'
										WHERE kelas_id = '$id'");

			if ($kelas) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=kelas'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=kelas'>";
			}	
		}
	$datakelas 		=	mysql_query("SELECT * FROM kelas WHERE kelas_id='$id'");
	$row			=	mysql_fetch_assoc($datakelas);
	}
?>

<?php 

	if (isset($_GET['instruksi-edit'])) {
		$id 		=	$_GET['instruksi-edit'];

		if (isset($_POST['update_instgs'])) {
			$judul			= $_POST['judul'];
        	$pelajaran 		= $_POST['pelajaran'];
        	$info           = $_POST['info'];
        	$username       = $_POST['username'];

			$sql 		=	("UPDATE instgs 
								SET
									`judul`='{$judul}',
									`pelajaran_id`='{$pelajaran}',
									`tanggal_selesai`='{$_POST['tgl_selesai']}',
									`username`='{$username}',
									`info`='{$info}'
							WHERE instgs_id = '$id'");
			$query= mysql_query($sql);
			if ( $query ) {
				echo "<script>alert('Data informasi instruksi tugas Berhasil Diubah'); window.history.go(-2);</script>";
			} else {
				echo "<script>alert('Data informasi instruksi tugas Gagal Diubah'); window.history.back();</script>";
			}

		}
		$datainstruksi 		=	mysql_query("SELECT * FROM instgs WHERE instgs_id='$id'");
		$row				=	mysql_fetch_assoc($datainstruksi);
	}
?>


<?php 

	if (isset($_GET['jam-edit'])) {
		$id 		=	$_GET['jam-edit'];

		if (isset($_POST['jam-update'])) {
			$nama 		=	$_POST['nama'];

			$jam 		=	mysql_query("UPDATE jam 
										SET `jam_nama` = '$nama'
										WHERE jam_id = '$id'");

			if ($jam) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=jam'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=jam'>";
			}	
		}
	$datajam 		=	mysql_query("SELECT * FROM jam WHERE jam_id='$id'");
	$row			=	mysql_fetch_assoc($datajam);
	}
?>

<?php 

	if (isset($_GET['soal-edit'])) {
		$id 		=	$_GET['soal-edit'];

		if(isset($_POST['soal-update'])){
        $no			= $_POST['id_kuis'];
        $judul 		= $_POST['judul'];
        $user 		=$_POST['id'];
        $kls 		=$_POST['kelas'];
        $soal 		= $_POST['soal'];
        $mapel		=$_POST['pelajaran'];
        $jaw1 		= $_POST['jawabanA'];
        $jaw2 		= $_POST['jawabanB'];
        $jaw3 		= $_POST['JawabanC'];
        $jaw4 		= $_POST['JawabanD'];
        $kunci      = $_POST['jawab'];
      	$jenis 		= $_POST['jenis'];
			$kuis 		=	mysql_query("UPDATE kuis
										SET 'id_kuis' = '$no', 
										'users_id' =$user
										'judul'    ='$judul',  
										'kelas_id' ='$kls',  
										'soal'     = '$soal', 
										'pelajaran'='$mapel', 
										'pil_a'    ='$jaw1', 
										 pil_b     ='$jaw2',
										'pil_c'    ='$jaw3', 
										'pil_d'    ='$jaw4', 
										'kunci'    ='$kunci'
										WHERE kuis = '$no'");

			if ($kuis) {
				echo "
			<div class='large-12 columns'>
				<div class='box bg-light-green'>
					<div class='box-header bg-light-green'>
						<div class='pull-right box-tools'>
							<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
						</div>
						<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
							<span class='text-white'>SUCCESS</span>
						</h3>
					</div>
					<div class='box-body ' style='display: block;'>
						<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
					</div>
				</div>
			</div>";
			echo "<meta http-equiv='refresh' content='1;URL=?kuis=tampil_kuis'>";
		}else {
			echo "
			<div class='large-12 columns'>
				<div class='box bg-light-yellow'>
					<div class='box-header bg-light-yellow'>
						<div class='pull-right box-tools'>
							<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
						</div>
						<h3 class='box-title '><i class='text-white  fontello-warning'></i>
							<span class='text-white'>Warning</span>
						</h3>
					</div>
					<div class='box-body ' style='display: block;'>
						<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
					</div>
				</div>
			</div>";
			echo "<meta http-equiv='refresh' content='1;URL=?soal=tampil_kuis'>";
			}	
		}
	$datainstruksi 		=	mysql_query("SELECT * FROM instgs WHERE kuis='$id'");
	$row				=	mysql_fetch_assoc($datakuis);
	}
?>


<?php 

	if (isset($_GET['pelajaran-edit'])) {
		$id 		=	$_GET['pelajaran-edit'];

		if (isset($_POST['pelajaran-update'])) {
			$idpel		= $_POST['pelajaran_id'];
			$gupel 		=	$_POST['gupel'];
			$mapel      = $_POST['mapel'];

			$pelajaran 	=	mysql_query("UPDATE pelajaran 
										SET 'pelajaran_nama' = '$mapel,
											users_id='$gupel,
										WHERE pelajaran_id = '$idpel'");

			if ($pelajaran) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=pelajaran'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=pelajaran'>";
			}	
		}
	$datapelajaran	=	mysql_query("SELECT * FROM pelajaran, users WHERE pelajaran_id='$id',users_nama='$gupel'");
	$row			=	mysql_fetch_assoc($datapelajaran);
	}
?>

<?php 

	if (isset($_GET['semester-edit'])) {
		$id 		=	$_GET['semester-edit'];

		if (isset($_POST['semester-update'])) {
			$nama 		=	$_POST['nama'];

			$semester 	=	mysql_query("UPDATE semester 
										SET `semester_nama` = '$nama'
										WHERE semester_id = '$id'");

			if ($semester) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=semester'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=semester'>";
			}	
		}
	$datasemester	=	mysql_query("SELECT * FROM semester WHERE semester_id='$id'");
	$row			=	mysql_fetch_assoc($datasemester);
	}
?>

<?php 

	if (isset($_GET['tahun-edit'])) {
		$id 		=	$_GET['tahun-edit'];

		if (isset($_POST['tahun-update'])) {
			$sql = ("
				UPDATE tahun SET
					`tahun_nama` = '{$_POST['nama']}',
					`semester` = '{$_POST['semester']}'
				WHERE tahun_id = '{$id}'");
			$query= mysql_query($sql);
			if($query){
				echo "<script>alert('Data informasi tahun ajaran berhasil diubah'); window.history.go(-2);</script>";
			}else {
				echo "<script>alert('Data informasi tahun ajaran gagal diubah'); window.history.back();</script>";
			}
				
		}

		$datatahun = mysql_query("SELECT * FROM tahun WHERE tahun_id='$id'");
		$row = mysql_fetch_assoc($datatahun);
	}
?>

<?php 

	if (isset($_GET['sekolah-edit'])) {
		$id 		=	$_GET['sekolah-edit'];

		if (isset($_POST['sekolah-update'])) {
			$nama 		=	$_POST['nama'];
			$telp 		=	$_POST['telp'];
			$alamat		=	$_POST['alamat'];
			$akreditasi	=	$_POST['akreditasi'];

			$sekolah 		=	mysql_query("UPDATE sekolah 
										SET `sekolah_nama` = '$nama', `sekolah_telp` = '$telp', `sekolah_alamat` = '$alamat', `sekolah_akreditasi` = '$akreditasi'
										WHERE sekolah_id = '$id'");

			if ($sekolah) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=sekolah'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?akademik=sekolah'>";
			}	
		}
	$datasekolah 		=	mysql_query("SELECT * FROM sekolah WHERE sekolah_id='$id'");
	$row				=	mysql_fetch_assoc($datasekolah);
	}
?>

<?php 

	if (isset($_GET['modul-edit'])) {
		$id = $_GET['modul-edit'];

		if (isset($_POST['modul-update'])) {
			$fileType= ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
			$nama = $_POST['nama'];
			$pelajaran = $_POST['pelajaran'];
			$tgl= date("Y-m-d");
			
			# cek file input
			if ( ! empty($_FILES['file']['tmp_name']) ) {
				# filter type file by extension
				if ( in_array(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION), $fileType) ) {
					# filter type file by size
					if ( $_FILES['file']['size'] > (1024000*10) ) {
						echo "<script>alert('Sorry, only size smaller than 10 MB files are allowed'); window.history.back();</script>";
					
					} else {
						# start unlink file
						$sql= ("SELECT * FROM modul WHERE id = '{$id}' ");
						$row= query_result($connect, $sql)['fetch_assoc'][0];
						if ( ! empty($row['file']) ) {
							if(file_exists('./files/' .$row['file'])){
								unlink('./files/' .$row['file']);
							}
						}
						# end unlink file

						$path_destination= './files/';
						# start generate name file exists
						$name = $_FILES['file']['name'];
						$rawBaseName = pathinfo( $name, PATHINFO_FILENAME );
						$original_name = $rawBaseName;
						$extension = pathinfo( $name, PATHINFO_EXTENSION );

						$i = 1;
						while( file_exists($path_destination.$rawBaseName.".".$extension ))
						{           
							$rawBaseName = ( string )$original_name.$i;
							$name = $rawBaseName.".".$extension;
							$i++;
						}
						# end generate name file exists

						$file_ext       = $extension;
						$file_size      = $_FILES['file']['size'];
						$file_tmp       = $_FILES['file']['tmp_name'];

						# upload file
						if (move_uploaded_file($_FILES['file']['tmp_name'] , $path_destination. $name)) {
							$sql= ("
								UPDATE `modul`
								SET
									`tanggal_upload`='{$tgl}',
									`nama_file`='{$nama}',
									`pelajaran_id`='{$pelajaran}',
									`tipe_file`='{$file_ext}',
									`ukuran_file`='{$file_size}',
									`file`='{$name}'
								WHERE id = '{$id}'
							");
						}else {
							echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
						}

					}
					
				} else {
					echo "<script>alert('Sorry, only DOC, DOCX, XLS, PPT, PPTX & PDF files are allowed'); window.history.back();</script>";
				}
				

			} else {
				$sql= ("
					UPDATE `modul` SET `nama_file`='{$nama}',`pelajaran_id`='{$pelajaran}' WHERE id = '{$id}'
				");
			}
			// print_r($sql);
			// die();
			$query= mysql_query($sql);
			if($query){
				echo "<script>alert('Data informasi materi berhasil diubah'); window.history.go(-2);</script>";
			}else {
				echo "<script>alert('Data informasi materi gagal diubah'); window.history.back();</script>";
			}
		}
		$datamodul	=	mysql_query("SELECT * FROM modul WHERE id='$id'");
		$row			=	mysql_fetch_assoc($datamodul);
	}
?>

<?php 

	if (isset($_GET['modul-validasi'])) {
		$id 		=	$_GET['modul-validasi'];

		if (isset($_POST['modul-validasi'])) {
			$status 		=	$_POST['status'];

			$modul 		=	mysql_query("UPDATE modul 
										SET `status` = '$status'
										WHERE id = '$id'");

			if ($modul) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?modul=download'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?modul=download'>";
			}	
		}
	$datamodul	=	mysql_query("SELECT * FROM modul WHERE id='$id'");
	$row			=	mysql_fetch_assoc($datamodul);
	}
?>

<?php 

	if (isset($_GET['jadwal-edit'])) {
		$id 		=	$_GET['jadwal-edit'];

		if (isset($_POST['jadwal-update'])) {
			$hari 		=	$_POST['hari'];
			$jam 		=	$_POST['jam'];
			$pelajaran  =	$_POST['pelajaran'];
			$kelas 		=	$_POST['kelas'];

			$jadwal 		=	mysql_query("UPDATE jadwal 
										SET `jadwal_hari` = '$hari', `jam_id` = '$jam', `pelajaran_id` = '$pelajaran', `kelas_id` = '$kelas'
										WHERE jadwal_id = '$id'");

			if ($jadwal) {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-green'>
						<div class='box-header bg-light-green'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  icon-thumbs-up'></i>
								<span class='text-white'>SUCCESS</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Well done!</strong> You successfully read this important alert message.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?jadwal=tampil'>";
			}else {
				echo "
				<div class='large-12 columns'>
					<div class='box bg-light-yellow'>
						<div class='box-header bg-light-yellow'>
							<div class='pull-right box-tools'>
								<span class='box-btn' data-widget='remove'><i class='icon-cross'></i></span>
							</div>
							<h3 class='box-title '><i class='text-white  fontello-warning'></i>
								<span class='text-white'>Warning</span>
							</h3>
						</div>
						<div class='box-body ' style='display: block;'>
							<p class='text-white'><strong>Warning!</strong> Best check yo self, you're not looking too good.</p>
						</div>
					</div>
				</div>";
				echo "<meta http-equiv='refresh' content='1;URL=?jadwal=tampil'>";
			}	
		}
	$datajadwal	=	mysql_query("SELECT * FROM jadwal WHERE jadwal_id='$id'");
	$row			=	mysql_fetch_assoc($datajadwal);
	}

	elseif (isset($_GET['edit-ulangan1'])) {
		$id 	=	$_GET['edit-ulangan1'];

		if (isset($_POST['edit-ulangan1'])) {
			$nilaipoin = $_POST['nilai_poin'];

			$nilai = mysql_query("UPDATE nilai
									SET `nilai_poin` = $nilaipoin
									WHERE nilai_id = $id");
			if ($nilai) {
			 	echo "<meta http-equiv='refresh' content='0;URL= ?nilai=Ulangan1 '/>";
			 } 
		}

		$nilai 	= 	mysql_query("SELECT nilai_id, nilai_poin FROM nilai WHERE nilai_id=$id");
		$row 	=	mysql_fetch_assoc($nilai);
	}
	elseif (isset($_GET['edit-ulangan2'])) {
		$id 	=	$_GET['edit-ulangan2'];

		if (isset($_POST['edit-ulangan2'])) {
			$nilaipoin = $_POST['nilai_poin'];

			$nilai = mysql_query("UPDATE nilai
									SET `nilai_poin` = $nilaipoin
									WHERE nilai_id = $id");
			if ($nilai) {
			 	echo "<meta http-equiv='refresh' content='0;URL= ?nilai=Ulangan2 '/>";
			 } 
		}

		$nilai 	= 	mysql_query("SELECT nilai_id, nilai_poin FROM nilai WHERE nilai_id=$id");
		$row 	=	mysql_fetch_assoc($nilai);
	}elseif (isset($_GET['edit-ulangan3'])) {
		$id 	=	$_GET['edit-ulangan3'];

		if (isset($_POST['edit-ulangan3'])) {
			$nilaipoin = $_POST['nilai_poin'];

			$nilai = mysql_query("UPDATE nilai
									SET `nilai_poin` = $nilaipoin
									WHERE nilai_id = $id");
			if ($nilai) {
			 	echo "<meta http-equiv='refresh' content='0;URL= ?nilai=Ulangan3 '/>";
			 } 
		}

		$nilai 	= 	mysql_query("SELECT nilai_id, nilai_poin FROM nilai WHERE nilai_id=$id");
		$row 	=	mysql_fetch_assoc($nilai);
	}elseif (isset($_GET['edit-uts'])) {
		$id 	=	$_GET['edit-uts'];

		if (isset($_POST['edit-uts'])) {
			$nilaipoin = $_POST['nilai_poin'];

			$nilai = mysql_query("UPDATE nilai
									SET `nilai_poin` = $nilaipoin
									WHERE nilai_id = $id");
			if ($nilai) {
			 	echo "<meta http-equiv='refresh' content='0;URL= ?nilai=UTS '/>";
			 } 
		}

		$nilai 	= 	mysql_query("SELECT nilai_id, nilai_poin FROM nilai WHERE nilai_id=$id");
		$row 	=	mysql_fetch_assoc($nilai);
	}elseif (isset($_GET['edit-uas'])) {
		$id 	=	$_GET['edit-uas'];

		if (isset($_POST['edit-uas'])) {
			$nilaipoin = $_POST['nilai_poin'];

			$nilai = mysql_query("UPDATE nilai
									SET `nilai_poin` = $nilaipoin
									WHERE nilai_id = $id");
			if ($nilai) {
			 	echo "<meta http-equiv='refresh' content='0;URL= ?nilai=UAS '/>";
			 } 
		}

		$nilai 	= 	mysql_query("SELECT nilai_id, nilai_poin FROM nilai WHERE nilai_id=$id");
		$row 	=	mysql_fetch_assoc($nilai);
	}elseif (isset($_GET['edit-raport'])) {
		$id 	=	$_GET['edit-raport'];

		if (isset($_POST['edit-raport'])) {
			$nilaipoin = $_POST['nilai_poin'];

			$nilai = mysql_query("UPDATE nilai
									SET `nilai_poin` = $nilaipoin
									WHERE nilai_id = $id");
			if ($nilai) {
			 	echo "<meta http-equiv='refresh' content='0;URL= ?nilai=Raport '/>";
			 } 
		}

		$nilai 	= 	mysql_query("SELECT nilai_id, nilai_poin FROM nilai WHERE nilai_id=$id");
		$row 	=	mysql_fetch_assoc($nilai);
	}
	elseif (isset($_GET['kuis-edit'])) {
		$id 	=	$_GET['kuis-edit'];

		if (isset($_POST['edit_kuis'])) {
			$kuis = mysql_query("UPDATE kuis
									SET
										soal_kuis= '{$_POST["soal"]}',
										pil_a= '{$_POST["pil_a"]}',
										pil_b= '{$_POST["pil_b"]}',
										pil_c= '{$_POST["pil_c"]}',
										pil_d= '{$_POST["pil_d"]}',
										kunci= '{$_POST["kunci"]}'
									WHERE id_kuis = $id");
			if ( $kuis ) {
				echo "<script>alert('Data Soal Berhasil Diubah'); window.history.go(-2);</script>";
			} else {
				echo "<script>alert('Data Soal Gagal Diubah'); window.history.back();</script>";
			}
		}

		$kuis 	= 	mysql_query("SELECT * FROM kuis WHERE id_kuis=$id");
		$row 	=	mysql_fetch_assoc($kuis);
	}
	elseif (isset($_GET['topik-edit'])) {
		$id 	=	$_GET['topik-edit'];
		if (isset($_POST['edit_topik'])) {
			$topik = mysql_query("
				UPDATE topik_kuis
				SET
					judul= '{$_POST["judul"]}',
					pelajaran_id= '{$_POST["pelajaran"]}',
					kelas_id= '{$_POST["kelas"]}',
					tanggal_selesai= '{$_POST["tgl_selesai"]}',
					jam= '{$_POST["jam"]}',
					menit= '{$_POST["menit"]}',
					detik= '{$_POST["detik"]}',
					info= '{$_POST["info"]}'
				WHERE id_topik = $id
			");
			if ( $topik ) {
				echo "<script>alert('Data Soal Berhasil Diubah'); window.history.go(-2);</script>";
			} else {
				echo "<script>alert('Data Soal Gagal Diubah'); window.history.back();</script>";
			}
		}

		$topik 	= 	mysql_query("SELECT * FROM topik_kuis WHERE id_topik=$id");
		$row 	=	mysql_fetch_assoc($topik);
	}
?>