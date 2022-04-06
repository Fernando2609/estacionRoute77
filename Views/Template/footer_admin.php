 <script>
   const base_url = "<?= base_url(); ?>";
 </script>  

   


<footer class="main-footer">
    
    <strong>Copyright &copy; 2021 <a href="#">Route 77</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= media(); ?>/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= media(); ?>/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= media(); ?>/js/adminlte.min.js"></script>
<script src="<?= media(); ?>/js/fontawesome.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= media(); ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= media(); ?>/js/plugins/jszip/jszip.min.js"></script>
<script src="<?= media(); ?>/js/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= media(); ?>/js/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= media(); ?>/js/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script>
<!-- Termina Datatables  & Plugins -->

 <!-- Bootstrap Select -->
<script src="<?= media(); ?>/js/bootstrap-select.min.js"></script>
 <!-- Bootstrap Switch -->
 <script src="<?= media(); ?>/js/plugins/bootstrap-switch/js/bootstrap-switch.js"></script>

<!-- Toastr -->
<script src="<?= media(); ?>/js/plugins/toastr/toastr.min.js"></script>
<!-- tinymce -->
<script src="<?= media(); ?>/js/tinymce/tinymce.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= media(); ?>/js/plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- Fullcalendar -->
<script src="<?= media(); ?>/js/plugins/fullcalendarV5/main.min.js"></script>
<script src="<?= media(); ?>/js/plugins/fullcalendarV5/locales-all.min.js"></script>

<!-- Page specific javascripts-->
<script src="<?= media(); ?>/js/funtions_admin.js"></script>
<script src="<?= media(); ?>/js/funtions_storage.js"></script>
<script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>


<!-- <script type="text/javascript" src="<?= media();?>/js/funtions_admin.js"></script> -->

<script>
  const imgB64="<?=  img64();  ?>"
  const smony = "<?= SMONEY; ?>";
</script>

<!-- Funcion de datatables -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
