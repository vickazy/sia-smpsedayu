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
                <span>Upload Tugas</span>
            </h3>
        </div>
        <!-- /.box-header -->


        <div class="box-body small-5" style="display: block;">
            <form data-abide method="POST" action="" role="form" enctype="multipart/form-data">                 
                <div class="name-field">
                    <label>Judul Instruksi<small> required</small>
                        <input type="text" name="judul" value="<?php echo $row['judul']; ?>" required>
                    </label>
                    <small class="error">Nama File Harus Di Isi</small>
                    <label>Pelajaran<small> required</small>
                       <select name="pelajaran" class="form-control" required>
                    <?php 
                    $iduser = $_SESSION['id'];
                        $pelajaran  =   mysql_query("SELECT * FROM pelajaran, kelas WHERE pelajaran.kelas_id=kelas.kelas_id AND pelajaran.users_id='$iduser'");

                        while ($row=mysql_fetch_array($pelajaran)) {
                    ?>
                        <option value="<?php echo $row['pelajaran_id']; ?>"><?php echo $row['pelajaran_nama']; ?> Kelas (<?php echo $row['kelas_nama']; ?>)</option>
                    <?php
                        }
                    ?>
                    
                </select>
                    </label>
                    <input type="hidden" name="username" value="<?php 
                                                    if (isset($_SESSION['nama'])) {
                                                        echo $_SESSION['nama'];
                                                     } 
                ?>">
                </div>
                <label>Tanggal Selesai
                        <input type="date" name="tgl_selesai" required>
                </label>
        </div>
        <div class="box-body small-12" style="display: block;">
                <tr><td colspan="2" width="100%" style="padding:10px;">Instruksi</td></tr>
                <tr><td style="padding:50px;"><textarea name="info"><?php echo $row['info'];?></textarea></td></tr>

                <button type="submit" class="tiny radius button bg-black-solid" name="update_instgs"><b><span class="fontello-minefield"></span> Update</b></button>
        </div>        
            </form>
           
                
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
                var editor = CKEDITOR.replace( '' );    

                
                CKFinder.setupCKEditor( editor, '' ) ;

                
            }
    </script>