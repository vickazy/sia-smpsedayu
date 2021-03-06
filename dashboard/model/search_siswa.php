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
                <span>Data Informasi Siswa Kelas <?php echo $_GET['q'] ?></span>
            </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body " style="display: block;">
            <form action="" method="post">
                <div class="row">
                    <div class="small-6 columns">
                        <label for="">Pilih Kelas</label>
                        <select name="kelas_id" required="">
                        <?php
                            $sql= ("
                                SELECT *
                                FROM kelas
                                WHERE 1=1
                            ");
                            foreach (query_result($connect, $sql)['fetch_assoc'] as $key => $value) {
                                echo '<option value="'.$value['kelas_id'].'">'.$value['kelas_nama'].'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="small-6 columns">
                        <label for="">Tahun Ajaran</label>
                        <?php
                            $sql= ("
                                SELECT *,
                                    IF(tahun.semester='1','Ganjil','Genap') AS semester_mod
                                FROM tahun
                                WHERE 1=1
                                    AND tahun_nama LIKE '%".date('Y')."%'
                            ");
                            $tahun= '';
                            $tahun .= '<select name="tahun_id" required >';
                            foreach (query_result($connect, $sql)['fetch_assoc'] as $key => $value) {
                                $tahun .= "<option value='{$value['tahun_id']}'>{$value['tahun_nama']} (Semester {$value['semester_mod']})</option>";
                            }
                            $tahun .= '</select>';
                            echo $tahun;
                        ?>
                    </div>
                </div>
                <input type="hidden" name="update_kelas_siswa" value="1">
                <button type="submit">Update Kelas</button>
                <hr>
                
                <?php 
                    if (isset($_GET['search-siswa'])) {
                        $htmls = '';
                        $no = 1;
                        $sql = ("SELECT *, IF(tahun.semester='1','Ganjil','Genap') AS semester_mod, IF( (SELECT pbm_id FROM pbm WHERE pbm.user_id=users.users_id ORDER BY pbm.pbm_id DESC LIMIT 1)=pbm.pbm_id, 1, 0 ) AS pbm_status FROM users INNER JOIN pbm ON pbm.user_id=users.users_id INNER JOIN tahun ON tahun.tahun_id=pbm.tahun_id INNER JOIN kelas ON kelas.kelas_id=pbm.kelas_id WHERE 1=1 AND users.users_level='siswa' AND pbm.kelas_id='{$_GET['search-siswa']}' ORDER BY tahun.tahun_nama DESC,users.users_nama ASC");
                        // print_r($sql);
                        
                        $header= query_result($connect, $sql)['fetch_assoc'][0];
                        $htmls .= '
                        <table id="exampleX" class="display large-12">
                            <tr>
                                <td width="25%"><b>Kelas</b></td>
                                <td width="25%">: '.$header['kelas_nama'].'</td>
                                <td width="25%"><b>Tahun Ajaran</b></td>
                                <td width="25%">: '.$header['tahun_nama'].' (Semester '.$header['semester_mod'].')</td>
                            </tr>
                        </table>
                        ';

                        $htmls .= '
                        <table id="example" class="display">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>Action</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <!-- <th>Tahun Ajaran</th>
                                    <th>Semester</th> -->
                                </tr>
                            </thead>

                            <tbody>
                            ';

                            foreach ( query_result($connect, $sql)['fetch_assoc'] as $key => $value) {
                                $htmls .= '
                                    <tr for="checkbox'.$no.'">
                                        <td>'.$no.'</td>
                                        <td>'.($value['pbm_status']==1? '<input name="user_id[]" value="'.$value['users_id'].'" id="checkbox'.$no.'" type="checkbox" checked>' : '-' ).'</td>
                                        <td>'.$value['users_noinduk'].'</td>
                                        <td>'.$value['users_nama'].'</td>
                                        <!-- <td>'.$value['tahun_nama'].'</td>
                                        <td>'.$value['semester_mod'].'</td> -->
                                    </tr>
                                ';
                                $no++;
                            }

                            # mencari data siswa belum punya kelas
                            $sql= ("
                            SELECT *,
                                (SELECT COUNT(*) FROM pbm WHERE pbm.user_id=users.users_id) AS count_pbm
                            FROM users
                            WHERE 1=1
                                AND users.users_level='siswa'
                                HAVING count_pbm < 1
                                ORDER BY users.users_nama ASC
                            ");
                            foreach ( query_result($connect, $sql)['fetch_assoc'] as $key => $value) {
                                $htmls .= '
                                    <tr for="checkbox'.$no.'">
                                        <td>'.$no.'</td>
                                        <td><input name="user_id[]" value="'.$value['users_id'].'" id="checkbox'.$no.'" type="checkbox"></td>
                                        <td>'.$value['users_noinduk'].'</td>
                                        <td>'.$value['users_nama'].'</td>
                                        <!-- <td> - </td>
                                        <td> - </td> -->
                                    </tr>
                                ';
                                $no++;
                            }
                            $htmls .= '
                            </tbody>
                        </table> 
                        ';
                        echo $htmls;

                    }
                ?>                    
                                   
            </form>
        </div>
        <!-- end .timeline -->
    </div>
    <!-- box -->
</div>