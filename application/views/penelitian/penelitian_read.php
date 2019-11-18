<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Penelitian Read</h2>
        <table class="table">
	    <tr><td>Nidn</td><td><?php echo $nidn; ?></td></tr>
	    <tr><td>Nama Dosen</td><td><?php echo $nama_dosen; ?></td></tr>
	    <tr><td>Jenis Penelitian</td><td><?php echo $jenis_penelitian; ?></td></tr>
	    <tr><td>Total Dana</td><td><?php echo $total_dana; ?></td></tr>
	    <tr><td>File Proposal</td><td><?php echo $file_proposal; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('penelitian') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>