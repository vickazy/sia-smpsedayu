<?php
    // echo '<pre>';
    // print_r($row);
    // echo '</pre>';
?>
<div class="large-12 columns">
    <div class="box">
        <div class="box-header bg-transparent">
            <!-- tools box -->
            <div class="pull-right box-tools">

                <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i>
                </span>
                <span class="box-btn" data-widget="remove"><i class="icon-cross"></i>
                </span>
            </div>
            <h3 class="box-title"><i class="fontello-th-large-outline"></i>
                <span>Update Topik Kuis</span>
            </h3>
        </div>
        <!-- /.box-header -->


        <div class="box-body small-5" style="display: block;">
            <!-- tambah topik -->
            <form data-abide method="POST" action="" role="form" enctype="multipart/form-data">                 
                <div class="name-field">
                    <label>Judul Topik<small> required</small>
                        <input value="<?php echo $row['judul'] ?>" type="text" name="judul" required>
                    </label>
                    <small class="error">Nama File Harus Di Isi</small>
                     <label>Mata Pelajaran</label>
                <select name="pelajaran" class="form-control" required>
                    <?php 
                    $iduser = $_SESSION['id'];
                        $pelajaran  =   mysql_query("SELECT * FROM pelajaran, kelas WHERE pelajaran.kelas_id=kelas.kelas_id AND pelajaran.users_id='$iduser'");

                        while ($rows=mysql_fetch_array($pelajaran)) {
                            
                    ?>
                        <option <?php echo ($row['pelajaran_id']==$rows['pelajaran_id'] ? "selected" : NULL )?> value="<?php echo $rows['pelajaran_id']; ?>"><?php echo $rows['pelajaran_nama']; ?> Kelas (<?php echo $rows['kelas_nama']; ?>)</option>
                    <?php
                        }
                    ?>
                </select>
            </div>
                <label>Kelas</label>
                    <select name="kelas" class="form-control" >
                    <?php 
                    $idus= $_SESSION['id'];
                        $kelas  =   mysql_query("SELECT * FROM pelajaran, kelas WHERE kelas.kelas_id=pelajaran.kelas_id AND pelajaran.users_id='$idus'");

                        while ($rows=mysql_fetch_array($kelas)) {
                    ?>
                        <option <?php echo ($row['kelas_id']==$rows['kelas_id'] ? "selected" : NULL )?> value="<?php echo $rows['kelas_id']; ?>"><?php echo $rows['kelas_nama']; ?></option>
                    <?php
                        }
                    ?>
                </select>
				 <label>Tanggal Selesai<small> required</small>
                        <input value="<?php echo $row['tanggal_selesai']?>" type="date" name="tgl_selesai" required>
                    </label>
					 <label>Jam<small> required</small>
                        <input value="<?php echo $row['jam']?>" type="text" name="jam" required>
                    </label>
					 <label>Menit<small> required</small>
                        <input value="<?php echo $row['menit']?>" type="text" name="menit" required>
                    </label>
					 <label>Detik<small> required</small>
                        <input value="<?php echo $row['detik']?>" type="text" name="detik" required>
                    </label>
                    <input type="hidden" name="username" value="<?php 
                                                    if (isset($_SESSION['nama'])) {
                                                        echo $_SESSION['nama'];
                                                     } 
                                                ?>">
                </div>
        </div>
        <div class="box-body small-12" style="display: block;">
                <tr><td colspan="2" width="100%" style="padding:10px;">Topik Kuis</td></tr>
                <tr><td style="padding:50px;"><textarea name="info"><?php echo $row['info'] ?></textarea></td></tr>
                 <input type="hidden" name="topik_edit" value="<?php echo $row['id_topik'] ?>">                                    
                <button type="submit" class="tiny radius button bg-black-solid" name="edit_topik" value="edit_topik"><b><span class="fontello-minefield"></span> Update</b></button>
        </div>        
            </form>
            <!-- end tambah topik -->
           
                
        <!-- end .timeline -->
    </div>
    <!-- box -->
</div>

<script src="../dashboard/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

            if ( typeof CKEDITOR == 'undefined' )
            {
                document.write(
                    'CKEditor not found');
            }
            else
            {
                var editor = CKEDITOR.replace( 'info' );    

                
                CKFinder.setupCKEditor( editor, '' ) ;

                
            }
    </script>