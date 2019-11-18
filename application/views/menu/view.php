
        <!-- Main content -->
            <div class="right_col" role="main">
        <div class="x_panel">
            <ol class="breadcrumb">
                    <li><i class='fa fa-home'></i> <a href="javascript:void(0)">Home</a></li>
                    <li><?php echo anchor($this->uri->segment(1), ucwords($title));?></li>
                    <li class="active"></i>Data</li>
                </ol>
        <section class="content">
        <div class="row">
         <section class="col-lg-12">
        <div class="box-body">
        <table class="table">
	    <tr><td>Menu</td><td><?php echo $menu; ?></td></tr>
	    <tr><td>Sub Menu</td><td><?php echo $sub_menu; ?></td></tr>
	    <tr><td>Icon</td><td><?php echo $icon; ?></td></tr>
	    <tr><td>Is Main Menu</td><td><?php echo $is_main_menu; ?></td></tr>
	    <tr><td>Menu Aktif</td><td><?php echo $menu_aktif; ?></td></tr>
	    <tr><td><a href="<?php echo site_url('menu') ?>" class="btn btn-default">Back</a></td><td></td></tr>
	</table>
        </div>

    </section>
    </div>
    </section>
</div>
</div>
        