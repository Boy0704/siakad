<div class="row">
    <form action="<?php echo $action; ?>" method="post"><table class="table table-bordered nowrap">
    <tr class="alert alert-info"><th colspan="2">Create menu</th></tr><tr>
        <td width="200" align="center">
            <label class="control-label">Menu</label>
        </td>
        <td>
            <div class="item form-group">
                <div class="col-md-6">
                   <input type="text" class="form-control" name="menu" id="menu" placeholder="Menu" value="<?php echo $menu; ?>" />
                   <div class="row">
                        <div class="col-md-6">
                             <?php echo form_error('menu','<div class="text-danger">','</div>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="200" align="center">
            <label class="control-label">Sub Menu</label>
        </td>
        <td>
            <div class="item form-group">
                <div class="col-md-6">
                   <input type="text" class="form-control" name="sub_menu" id="sub_menu" placeholder="Sub Menu" value="<?php echo $sub_menu; ?>" />
                   <div class="row">
                        <div class="col-md-6">
                             <?php echo form_error('sub_menu','<div class="text-danger">','</div>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="200" align="center">
            <label class="control-label">Icon</label>
        </td>
        <td>
            <div class="item form-group">
                <div class="col-md-6">
                   <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?php echo $icon; ?>" />
                   <div class="row">
                        <div class="col-md-6">
                             <?php echo form_error('icon','<div class="text-danger">','</div>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="200" align="center">
            <label class="control-label">Is Main Menu</label>
        </td>
        <td>
            <div class="item form-group">
                <div class="col-md-6">
                   <?php echo combo_menu('is_main_menu', 'menu', 'menu', 'menu', 'id', $is_main_menu); ?>
                   <div class="row">
                        <div class="col-md-6">
                             <?php echo form_error('is_main_menu','<div class="text-danger">','</div>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td width="200" align="center">
            <label class="control-label">Menu Aktif</label>
        </td>
        <td>
            <div class="item form-group">
                <div class="col-md-6">
                   <select name="menu_aktif" class="form-control">
                       <option value="1">AKTIF</option>
                       <option value="0">TIDAK AKTIF</option>
                   </select>
                   <div class="row">
                        <div class="col-md-6">
                             <?php echo form_error('menu_aktif','<div class="text-danger">','</div>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr><tr>
        <td colspan="2">
            <div class="form-group">
            <div class="col-md-offset-3">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                <a href="<?php echo site_url('menu') ?>" class="btn btn-default">Cancel</a>
            </div>
            </div>
        </td>
    </tr>
	</table>
	</form>


</div>

    