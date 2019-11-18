
<div class="row">
 
    <div class="col-md-6">
        <?php echo anchor(site_url('menu/create'),' Tambah Data', 'class="fa fa-plus btn btn-primary btn-lg"'); ?>
    </div>
    <div class="col-md-6 text-center">
        <div style="margin-top: 8px" id="message">
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        </div>
    </div>

<style>
    th, td{
        text-align:center;
    }
</style>

<table class="table table-bordered table-striped table-hover" id="datatable">
    <thead>
    <tr>
        <th>No</th>
<th>Menu</th>
<th>Sub Menu</th>
<th>Icon</th>
<th>Is Main Menu</th>
<th>Menu Aktif</th>
<th>Action</th>
                    </tr>
                    </thead>
                    <tbody><?php
                    $start = 0;
                    foreach ($menu_data as $menu)
                    {
                         ?>

    <tr>
    
	<td width="80px"><?php echo ++$start ?></td>
	<td><?php echo ucwords($menu->menu) ?></td>
	<td><?php echo ucwords($menu->sub_menu) ?></td>
	<td><?php echo ucwords($menu->icon) ?></td>
	<td><?php echo ucwords($menu->is_main_menu) ?></td>
	<td><?php echo ucwords($menu->menu_aktif) ?></td>
	<td><center>
		<?php 
		echo anchor(site_url('menu/read/'.$menu->id),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'Detail','class'=>'btn btn-info btn-sm', 'data-placement'=>'bottom', 'data-toggle'=>'tooltip')); ?>
		<?php 
		echo anchor(site_url('menu/update/'.$menu->id),'<i class="glyphicon glyphicon-edit"></i>',array('title'=>'Edit','class'=>'btn btn-primary btn-sm', 'data-placement'=>'bottom', 'data-toggle'=>'tooltip')); ?> 
		<?php 
		echo anchor(site_url('menu/delete/'.$menu->id),'<i class="glyphicon glyphicon-trash"></i>','title="Delete" class="btn btn-danger btn-sm" data-placement="bottom" data-toggle="tooltip" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); ?> 
	</center></td>
</tr>
        <?php
    }
    ?>
</tbody>
</table>
</div>
