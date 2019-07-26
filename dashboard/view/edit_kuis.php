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
                <span>Upload soal</span>
            </h3>
        </div>
        <!-- /.box-header -->


        <div class="box-body small-5" style="display: block;">
            <!-- tambah topik -->
            <form data-abide method="POST" action="" role="form" enctype="multipart/form-data">                 
                </div>

                    <div class="name-field">
                    <label>Soal<small> required</small>
                        <textarea name="soal" style="margin: 0px 0px 16px; width: 398px; height: 265px;" required><?php echo $row[0]['soal_kuis'] ?></textarea>
                    </label>
                </div>
                <div class="name-field">
                    <label>jawaban A<small> required</small>
                        <input value="<?php echo $row[0]['pil_a'] ?>" type="text" name="pil_a" required>
                    </label>
					</div>
				<div class="name-field">
                    <label>jawaban B<small> required</small>
                        <input value="<?php echo $row[0]['pil_b'] ?>" type="text" name="pil_b" required>
                    </label>
				</div>
			<div class="name-field">
                    <label>Jawaban C<small> required</small>
                        <input value="<?php echo $row[0]['pil_c'] ?>" type="text" name="pil_c" required>
                    </label>
			</div>
			<div class="name-field">
                    <label>Jawaban D<small> required</small>
                        <input value="<?php echo $row[0]['pil_d'] ?>" type="text" name="pil_d" required>
                    </label>
			</div>                    
            <div class="name-field" >
                    <label>Kunci Jawaban</label>
	                    <input type="radio"   id="pokemonRed" name="kunci" value="A" <?php ($row[0]['kunci']=='A')? 'checked' : NULL ?> >
                        <label for="pokemonRed">A</label>
                        <input type="radio"   id="pokemonBlue" name="kunci" value="B" <?php ($row[0]['kunci']=='B')? 'checked' : NULL ?> >
                        <label for="pokemonBlue">B</label>
	                    <input type="radio"   id="pokemonRed" name="kunci" value="C" <?php ($row[0]['kunci']=='C')? 'checked' : NULL ?>>
                        <label for="pokemonRed">C</label>
                        <input type="radio"   id="pokemonBlue" name="kunci" value="D" <?php ($row[0]['kunci']=='D')? 'checked' : NULL ?>>
                        <label for="pokemonBlue">D</label>
                 </div>
             </div>
             
        </div>
                <div>
                <button type="submit" class="tiny radius button bg-black-solid" name="upload_soal" value="upload_soal"><b><span class="fontello-minefield"></span> Update</b></button>
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
                var editor = CKEDITOR.replace( 'Soal' );    

                
                CKFinder.setupCKEditor( editor, '' ) ;

                
            }
    </script>