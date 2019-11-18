<?php

function combo_menu($nama_inputan, $nama_id, $nama_table, $nama_field, $id_data, $selected)
{
	$CI =& get_instance();
	$combo = "<select name='$nama_inputan' id='$nama_id' class='form-control'>";
		// ambil data di database
	$combo .= "<option value='0'>MENU UTAMA</option>";
	$data = $CI->db->get_where($nama_table, array('menu_aktif'=>1))->result();
	foreach ($data as $row) {
		$combo .= "<option value='".$row->$id_data."'";
		$combo .= $selected==$row->$id_data?"selected='selected'":"";
		$combo .= ">".strtoupper($row->$nama_field)."</option>";
	}
	$combo .= "</select>";
	return $combo;
}


function menu_help($field, $field2, $nama_table, $nama_table2, $sub_menu, $icon)
{
	$CI =& get_instance();
		// ambil data di database
	$level = $CI->session->userdata('level');
	if ($level==5 OR $level==6) {
		$data = $CI->db->order_by("id_mainmenu", 'asc');
	}else {
		$data = $CI->db->order_by($field, 'asc');
	}
	$data = $CI->db->get_where($nama_table, array('aktif'=>'y','level'=>$level));
	if (!empty($data))
	{
		foreach ($data->result() as $row)
		{
			$sub_menu  = $CI->db->order_by($field2, 'asc');
			$sub_menu  = $CI->db->get_where($nama_table2, array('id_mainmenu'=>$row->id_mainmenu,'aktif'=>'y'));
			if ($sub_menu->num_rows() > 0)
			{
            	echo "<li><a><i class='".$row->$icon."'></i>".ucwords($row->nama_mainmenu)."<span class='fa fa-chevron-down'></span></a>";
            	 echo "<ul class='nav child_menu'>";
	            foreach($sub_menu->result() as $sub)
	            {
	   				echo "<li>". anchor($sub->link,  ucwords($sub->nama_submenu)) . "</li>";
	            }
	            echo "</ul></li>";
			}
			else
			{
				$level = $CI->session->userdata('level');
				if ($level == 4) {
					if ($row->nama_mainmenu == 'Tunggakan Pembayaran') {
						$id=$CI->session->userdata('keterangan');
           				$nim=getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
           				$tahun_akademik_id=  getField('student_mahasiswa', 'angkatan_id', 'nim', $nim);
					    // konsentrasi
					    $konsentrasi_id=getField('student_mahasiswa', 'konsentrasi_id', 'nim', $nim);
					    $jenis_bayar=  $CI->db->query('SELECT * from keuangan_jenis_bayar ')->result();
					    $sum = 0;
					    foreach ($jenis_bayar as $jb)
					    {
					        $jumlah_bayar   =(int) get_biaya_kuliah($tahun_akademik_id, $jb->jenis_bayar_id, $konsentrasi_id, 'jumlah');
					        $sudah_bayar   = (int)get_biaya_sudah_bayar($nim, $jb->jenis_bayar_id);
					        $sisa1         = $jumlah_bayar-$sudah_bayar;
					         $keterangan           =   $sisa1<=0?'Lunas':'Tunggakan '.$sisa1;
					        if ($keterangan != "Lunas") {
					        	$sum += count($keterangan);
					        }

					    }

					    // looping semester
					    $smt_aktif = getField('student_mahasiswa', 'semester_aktif', 'nim', $nim);
					    $sum2 = 0;
					    for($i=1;$i<=$smt_aktif;$i++)
					    {
					        $spp            =   (int) get_biaya_kuliah($tahun_akademik_id, 3, $konsentrasi_id, 'jumlah');
					        $spp_udah_bayar =   (int)get_semester_sudah_bayar($nim, $i);
					        $sisa2           =   $spp-$spp_udah_bayar;
					        $keterangan           =   $sisa2<=0?'Lunas':'Tunggakan '.$sisa2;
					        if ($keterangan != "Lunas" ) {
					        	$sum2 += count($keterangan);
					        	// $sum3 += $sum2+$sum;
					        }
					    }
					    $total = $sum + $sum2;

						if ($total != 0)
						{
					 		echo "<li>" . anchor(ucwords($row->link), '<i class="' . $row->icon . '"></i>' . ucwords($row->nama_mainmenu) . ' <span class="badge bg-red">'.$total.'</span>') ."</li>";
					 	}
					 	else{
					 		echo "<li>" . anchor(ucwords($row->link), '<i class="' . $row->icon . '"></i>' . ucwords($row->nama_mainmenu) . ' <i class="fa fa-check text-green" style="width:5px;"></i>') ."</li>";
					 	}

					}
					else{
						echo "<li>" . anchor(ucwords($row->link), '<i class="' . $row->icon . '"></i>' . ucwords($row->nama_mainmenu))."</li>";
					}
				}
				else{
				 echo "<li>" . anchor(ucwords($row->link), '<i class="' . $row->icon . '"></i>' . ucwords($row->nama_mainmenu)) . "</li>";
				}
			}

		}
	}
	else
	{
		echo "";
	}

}


function select2_dinamis($name, $nama_table, $nama_field, $placeholder)
{
	$CI =& get_instance();
	$select2 = "<select name='".$name."'> class='form-control select2 select2-hidden-access' data-placeholder='".$placeholder."' style='width:100%' tabindex='-1' ";
	$data = $CI->db->get($nama_table)->result();
	foreach ($data as $row) {
		$select2 .= "<option>".$row->$nama_field."</option>";
	}
	$select2 .= "</select>";
	return $select2;
}




?>
