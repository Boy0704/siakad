<?php
echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-sm btn-primary'));
?>
<!-- <hr> -->
<div class="row">
    <table id="datatable" class="table table-bordered">
    	<thead>
    		<tr>
    			<th>No</th>
    			<th>Jenis Pembayaran</th>
    			<th>Opsi</th>
    		</tr>
    	</thead>
   
    <?php 
    	$no=1;
			foreach ($record as $r) 
            {
                $pk=  $r->jenis_bayar_id;
                $delete         =anchor($this->uri->segment(1).'/delete/'.$pk,'<span class="btn btn-sm btn-danger fa fa-trash"></span>', array('onclick'=>"return confirm('anda yakin akan menghapus data ini ?')", 'data-placement'=>'bottom','data-toggle'=>"tooltip", 'title'=>'hapus'));
                $edit           =anchor($this->uri->segment(1).'/edit/'.$pk,'<span class="btn btn-sm btn-primary fa fa-edit"></span>',array('data-placement'=>'bottom','data-toggle'=>"tooltip", 'title'=>'hapus'));
                	echo "<tr>
	                <td class='text-center'>".$no++."</td>
	                <td>".strtoupper($r->keterangan)."</td>";
	                echo "<td class='text-center'>".$edit.$delete."</td>
	                
                </tr>";
            }

    ?>
     </table>
</div>