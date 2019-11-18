
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
<?php
echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-sm btn-primary'));
?>
<hr>
<div class="row">
    <table id="datatable" class="table table-bordered">
    	<thead>
    		<tr>
    			<th width="1%">No</th>
    			<th width="39%">Kepala Bagian</th>
    			<th width="50%">Dosen</th>
    			<th width="10%">Opsi</th>
    		</tr>
    	</thead>

    <?php
    	$no=1;
	foreach ($record as $r)
            {
                $pk= $r->kepala_bagian_id;
                $delete = anchor($this->uri->segment(1).'/delete/'.$pk, '<span class="btn btn-sm btn-danger fa fa-trash"></span>', array('title'=>'Delete Data', 'data-placement'=>'bottom','data-toggle'=>"tooltip"));
                $edit = anchor($this->uri->segment(1).'/edit/'.$pk, '<span class="btn btn-sm btn-primary fa fa-edit"></span>', array('title'=>'Edit Data', 'data-placement'=>'bottom','data-toggle'=>"tooltip"));
                if ($r->dosen_id!='') {
                  $cek_dosen = $this->db->get_where('app_dosen', array('dosen_id'=>$r->dosen_id));
                  if ($cek_dosen->num_rows()==0) {
                    $nama_lengkap = '-';
                  }else {
                    $nama_lengkap = $cek_dosen->row()->nama_lengkap;
                  }
                }else {
                  $nama_lengkap = '-';
                }
                echo "<tr>
	                <td class='text-center'>".$no++."</td>
	                <td>".$r->nama_kepala_bagian."</td>
	                <td>".ucwords($nama_lengkap)."</td>";
	               echo "<td class='text-center'>".$edit.$delete."</td>

                </tr>";
            }

    ?>
     </table>
</div>
