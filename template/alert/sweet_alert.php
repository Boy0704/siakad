 <script>
   
  $(document).ready(function()
  {
    // readProducts(); /* it will load products when document loads */
    $(document).on('click', '#keluar', function(e)
    {
      keluar();
      e.preventDefault();
    });
  });

  $(document).ready(function()
  {
    // readProducts(); /* it will load products when document loads */
    $(document).on('click', '#setting', function(e)
    {
      setting();
      // e.preventDefault();
    });
  });

  function setting() {
      window.location.href="<?php echo base_url() ?>setting";
  }
  
  function keluar(){
    
    swal({
      title: 'Yakin.. Anda Ingin Keluar?',
      text: "jika Mengklik yes maka akan keluar dari sistem!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!',
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
          window.location.href="<?php echo base_url() ?>login/logout";
       }else {
          swal("Anda Membatalkan! :)", "","info");
        }
    });
  }
  

  </script>

 