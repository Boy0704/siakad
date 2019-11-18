<?php
echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-sm btn-primary'));
?>
<?php
echo anchor('submenu','<span class="fa fa-align-left"></span> Sub Menu',array('class'=>'btn btn-sm btn-default','style'=>'float:right;'));
?>
<hr>
<div class="row">
    <table id="datatable" class="table table-bordered">
    	<thead>
    		<tr>
    			<th>No</th>
    			<th>Main menu</th>
    			<th>level</th>
    			<th>link</th>
    			<th>aktif</th>
    			<th>Opsi</th>
    		</tr>
    	</thead>

    <?php
    	$no=1;
	foreach ($record as $r)
            {
                $pk= $r->id_mainmenu;
                $aktif          =$r->aktif=='y'?'Aktif':'Tidak';
                $iconaktif = anchor($this->uri->segment(1).'/status/y/'.$pk, '<span class="btn btn-sm btn-info fa fa-eye"></span>', array('title'=>'Aktifkan','data-placement'=>'bottom','data-toggle'=>"tooltip"));
                $iconnonaktif = anchor($this->uri->segment(1).'/status/t/'.$pk, '<span class="btn btn-sm btn-info  fa fa-eye-slash"></span>', array('title'=>'Non Aktifkan','data-placement'=>'bottom','data-toggle'=>"tooltip"));
                $icon           =$r->aktif=='y'?$iconnonaktif:$iconaktif;
                $delete = anchor($this->uri->segment(1).'/delete/'.$pk, '<span class="btn btn-sm btn-danger fa fa-trash"></span>', array('title'=>'Delete Data', 'data-placement'=>'bottom','data-toggle'=>"tooltip"));
                $edit = anchor($this->uri->segment(1).'/edit/'.$pk, '<span class="btn btn-sm btn-primary fa fa-edit"></span>', array('title'=>'Edit Data', 'data-placement'=>'bottom','data-toggle'=>"tooltip"));

                echo "<tr>
	                <td class='text-center'>".$no++."</td>
	                <td>".$r->nama_mainmenu."</td>";
	                $CI =& get_instance();
	                echo "<td>".$CI->level($r->level)."</td>
	                <td>".anchor($r->link, $r->link),"<span class'".$r->icon."'>"."</td>";
	                if ($r->aktif == 'y')
                    {
                        echo "<td class='text-center'><span class='label label-success'>$aktif</span></td>";
                    }
                    else
                    {
                        echo "<td class='text-center'><span class='label label-warning'>$aktif</span></td>";
                    }
	               echo "<td class='text-center'>".$icon.$edit.$delete."</td>

                </tr>";
            }


    function level($id)
    {
        if($id==1)
        {
            return "Admin";
        }
        elseif($id==2)
        {
            return "Jurusan";
        }
        elseif($id==3)
        {
            return 'Dosen';
        }
        else
        {
            return "Mahasiswa";
        }

    }

    ?>
     </table>
</div>
