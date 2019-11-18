<form action="<?php echo $action; ?>" method="post">
        <div class="form-group">
            <label for="varchar">Nidn <?php echo form_error('nidn') ?></label>
            <input type="text" class="form-control" name="nidn" id="nidn" placeholder="Nidn" value="<?php echo $nidn; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Nama Dosen <?php echo form_error('nama_dosen') ?></label>
            <input type="text" class="form-control" name="nama_dosen" id="nama_dosen" placeholder="Nama Dosen" value="<?php echo $nama_dosen; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Jenis Penelitian <?php echo form_error('jenis_penelitian') ?></label>
            <!-- <input type="text" class="form-control" name="jenis_penelitian" id="jenis_penelitian" placeholder="Jenis Penelitian" value="<?php echo $jenis_penelitian; ?>" /> -->
            <select name="jenis_penelitian" class="form-control">
                <option value="">Jenis Penelitian</option>
                <option value="Mandiri">Mandiri</option>
                <option value="PNBP">PNBP</option>
                <option value="RM">RM</option>
            </select>
        </div>
        <div class="form-group">
            <label for="int">Total Dana <?php echo form_error('total_dana') ?></label>
            <input type="number" class="form-control" name="total_dana" id="total_dana" placeholder="Total Dana" value="<?php echo $total_dana; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">File Proposal </label>
            <input type="file" class="form-control" name="file_proposal" id="file_proposal" placeholder="File Proposal"  />
        </div>
        <input type="hidden" name="id_penelitian" value="<?php echo $id_penelitian; ?>" /> 
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
        <a href="<?php echo site_url('penelitian') ?>" class="btn btn-default">Cancel</a>
    </form>