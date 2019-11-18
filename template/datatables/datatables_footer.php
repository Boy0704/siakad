 <!-- jQuery -->

<script src="<?php echo base_url() ?>template/vendors/jquery/dist/jquery.min.js"></script> 
<script src="<?php echo base_url() ?>template/vendors/nprogress/nprogress.js"></script>
<script src="<?php echo base_url() ?>template/vendors/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url() ?>template/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/datatables/js/responsive.bootstrap.min.js"></script>  
<script src="<?php echo base_url() ?>template/build/js/custom.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/dist/sweetalert.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/dist/sweetalert-dev.js"></script>
<script src="<?php echo base_url() ?>template/vendors/google-code-prettify/src/prettify.js"></script>
<script src="<?php echo base_url() ?>assets/select2/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<script src="<?php echo base_url() ?>template/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
 
  <script>
  // var loading = document.getElementById('loading');
  // window.addEventListener('load',function(){
  //   loading.style.display="none";
  // });
  </script>

  <script type="text/javascript">
  $(function () {

    $(".select2").select2();
  
  });

</script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable({
          scrollY: 360,
          scrollCollapse: true,
          scroller: true,
          responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
          

        });

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          // ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->


  </body>
</html>

