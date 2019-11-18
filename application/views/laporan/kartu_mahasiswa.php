<link href="<?php echo base_url() ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<body onload="window.print()">
    
</body>
<?php  foreach ($data as $record) { ?>
	
<div class="container">
<img src="<?php echo base_url() ?>uploads/kartu_mahasiswa/img.png" alt="">
<img style="border-radius: 100%;margin-left:25px; margin-top: -425px;height: 130px;width: 130px;" src="<?php echo base_url() ?>images/logo/logouit.gif" alt="">
</div>  
<div class="isi">
<h4 style="margin-left:310px;margin-top:-235px;padding-top: 7px; color: black "><?php echo $record->nim; ?></h4>
<h4 style="margin-left:310px;margin-top:-7px;padding-top: 7px; color: black "><?php echo ucwords($record->nama); ?></h4>
<h4 style="margin-left:310px;margin-top:-7px;padding-top: 6px; color: black "><?php echo ucwords($record->tanggal_lahir); ?></h4>
<h4 style="margin-left:310px;margin-top:-7px;padding-top: 6px; color: black "><?php echo ucwords($record->alamat); ?></h4>
</div>
<div class="foto">
    <?php if (!empty($record->foto)) { ?>
    <img style="height: 138px;width: 120px;margin-top:-130px;margin-left: 65px; border-radius: 4px;" class="img-responsive avatar-view" src="<?php echo base_url('uploads/'.$record->foto); ?>" alt="Avatar" title="Change the avatar">
 <?php }else{ ?>
    <img style="height: 138px;width: 120px;margin-top:-130px;margin-left: 65px; border-radius: 4px;" class="img-responsive avatar-view" src="<?php echo base_url('images/user.png'); ?>" alt="Avatar" title="Change the avatar">
   <?php } ?>
</div>
<div class="barcode">
   <?php $kode = $record->nim ?>
<img style="margin-left: 380px;margin-top:10px;" src="<?php echo site_url();?>/Laporan/generate/<?php echo $kode;?>">
</div>
<div class="qrcode">
   <?php $kode = $record->nim ?>
<img style="margin-left: 560px;margin-top:-100px;" src="<?php echo site_url();?>/Laporan/FunctionName/<?php echo $kode;?>">
</div>
<br>
<br>

<?php } ?>
                              
