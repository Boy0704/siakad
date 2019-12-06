<body onload="window.print()">

</body>
<style type="text/css">
    body
    {
        font-family: sans-serif;
        font-size: 14px;
    }
    th{
        padding: 5px;
        font-weight: bold;
        font-size: 12px;
    }
    td{
        font-size: 12px;
        padding: 3px;
    }
    h2{
        text-align: left;
        margin-bottom: 13px;
    }
    .potong
    {
        page-break-after:always;
    }
</style>

<table border="0" width="48%" background="<?php echo base_url("images/kartu_mhs.jpg"); ?>">
  <tr>
    <td colspan="2">
      <table border="0" style="border-collapse: collapse;width: 100%;margin-bottom:-10px;margin-top:-5px;">
          <tr>
             <th style="text-align: center; width: 10px;"><img src="<?php echo base_url('images/logo/logouit.png') ?>" alt="" width="50"></th>
             <td style="text-align: center;font-size: 10px; font-weight: bold;">
               <div style="margin-left: -20px;margin-top:0px;">
                 SEKOLAH TINGGI AGAMA ISLAM NEGERI <br>
                 <p style="font-size:9px;margin-top:2px;">SULTAN ABDURAHMAN</p>
               </div>
                <div style="margin-left: -20px;margin-top:-5px;font-size: 5px;">
                  Alamat : Jl. MT. Haryono , No. 01 Kel. Tanjung Unggat, Kec. Bukit Bestari Kota Tanju 29122 <br> Telp / Fax 0813-6685-5307 E.Mail : email : info@stainkepri.ac.id
                </div>
              </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <hr size="0" color="black" style="margin:0px;margin-bottom:1px;">
      <hr size="2" color="black" style="margin:0px;">
    </td>
  </tr>
  <tr>
    <td style="padding-left:10px;background-image: linear-gradient(to left, rgba(255,0,0,0), rgba(10,150,0,1));">
      <b style="font-size:12px;color:#fff;">KARTU MAHASISWA</b>
    </td>
    <td rowspan="5" width="50">
      <center><img src="<?php echo base_url($this->M_users->cek_filename($q->foto)); ?>" width="90" height="100" style="border:1px solid#f1f1f1;margin-right:5px;"></center>
    </td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td style="font-size:10px;padding-left:10px;color:#000;background:#82B894;opacity:0.8;filter:alpha(opacity=80);">
        <?php echo $this->db->get_where('student_mahasiswa',"mahasiswa_id='$q->mahasiswa_id'")->row()->nama; ?>
        <br>
        <?php echo $q->nim; ?>
    </td>
  </tr>
  <tr>
    <td style="font-size:6px;padding-left:8px;">
        <?php echo ucwords($q->tempat_lahir); ?>, <?php echo $this->M_users->tgl_id(date('d-m-Y',strtotime($q->tanggal_lahir))); ?>
    </td>
  </tr>
  <tr>
    <td style="font-size:6px;height:45px;padding-left:8px;" valign="top">
        <?php echo ucwords($q->alamat); ?>
    </td>
  </tr>
</table>
