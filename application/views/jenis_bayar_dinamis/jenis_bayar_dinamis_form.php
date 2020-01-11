<form action="<?php echo $action; ?>" method="post">
        <div class="form-group">
            <label for="varchar">Jenis Bayar Dinamis <?php echo form_error('jenis_bayar_dinamis') ?></label>
            <input type="text" class="form-control" name="jenis_bayar_dinamis" id="jenis_bayar_dinamis" placeholder="Jenis Bayar Dinamis" value="<?php echo $jenis_bayar_dinamis; ?>" />
        </div>
        <input type="hidden" name="id_jenis_bayar_dinamis" value="<?php echo $id_jenis_bayar_dinamis; ?>" /> 
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
        <a href="<?php echo site_url('jenis_bayar_dinamis') ?>" class="btn btn-default">Cancel</a>
    </form>