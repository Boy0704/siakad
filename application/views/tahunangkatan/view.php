<?php
echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-primary btn-sm'))
?>
<table id="datatable" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        $i=1;
        foreach ($record as $r)
        {
        ?>
        
        <tr>
            <td align="center"><?php echo $i;?></td>
            <td><?php echo strtoupper($r->keterangan);?></td>
            <?php if ($r->aktif == 'y'): ?>
                <td>
                    <span class="label label-success"><?php echo $r->aktif=='y'?'OPEN':'CLOSED'?></span>
                </td>
            <?php else: ?>
                <td>
                    <span class="label label-danger"><?php echo $r->aktif=='y'?'OPEN':'CLOSED'?></span>
                </td>
            <?php endif ?>
            <td class="text-center">
                <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->angkatan_id;?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/delete/'.$r->angkatan_id;?>" data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </td>
        </tr>
        <?php $i++;}?>
        
        
    </tbody>
</table>
<!-- END Datatables -->
                    
