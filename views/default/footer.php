            <footer class="main-footer">
                <strong>&copy; 2017 | ALUImóveis - Versão 1.0.0
                <div class="pull-right hidden-xs">
                    Desenvolvidor por <a href="https://www.linkedin.com/in/dirsouza/" target="_blank">Diogo Souza</a>
                </div>
            </footer>
        </div>
        <!-- ./wrapper -->

            <!-- jQuery 3 -->
            <script src="../../lib/plugins/jquery/js/jquery.min.js"></script>
            <!-- Bootstrap 3.3.7 -->
            <script src="../../lib/plugins/bootstrap/js/bootstrap.min.js"></script>
            <!-- Bootstrap WYSIHTML5 -->
            <script src="../../lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
            <!-- Slimscroll -->
            <script src="../../lib/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
            <!-- Date Picker -->
            <script src="../../lib/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
            <!-- DataTables -->
            <script src="../../lib/plugins/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../../lib/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
            <!-- DataTables Responsive -->
            <script src="../../lib/plugins/datatables/extension/responsive/js/dataTables.responsive.min.js"></script>
            <script src="../../lib/plugins/datatables/extension/responsive/js/responsive.bootstrap.min.js"></script>
            <!-- Select2 -->
            <script src="../../lib/plugins/select2/js/select2.full.min.js"></script>
            <!-- Input Mask -->
            <script src="../../lib/plugins/input-mask/jquery.inputmask.js"></script>
            <!-- jQuery Validate -->
            <script src="../../lib/plugins/jquery-validation/jquery.validate.min.js"></script>
            <!-- Toastr -->
            <script src="../../lib/plugins/toastr/js/toastr.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../../lib/template/js/adminlte.min.js"></script>
            <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
            <script src="../../lib/template/js/pages/dashboard.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../../lib/template/js/demo.js"></script>
            <!-- Personal JS -->
            <script src="../../lib/personal/js/personal.js"></script>
            <?php switch ($_SESSION["page"]):
                case "locator": ?>
                    <script src="../../lib/personal/js/locator.js"></script>
                    <?php break;
                case "renter": ?>
                    <script src="../../lib/personal/js/renter.js"></script>
                    <?php break;
                case "immobile": ?>
                    <script src="../../lib/personal/js/immobile.js"></script>
                    <?php break;
                case "contract": ?>
                    <script src="../../lib/personal/js/contract.js"></script>
                    <script src="../../lib/plugins/jquery-maskmoney/js/jquery.maskMoney.min.js"></script>
                    <script src="../../lib/plugins/moment/js/moment.js"></script>
                    <?php break;
                case "discount": ?>
                    <script src="../../lib/personal/js/discount.js"></script>
                    <script src="../../lib/plugins/jquery-maskmoney/js/jquery.maskMoney.min.js"></script>
                    <?php break;
                case "receipt": ?>
                    <script src="../../lib/personal/js/receipt.js"></script>
                    <script src="../../lib/plugins/jquery-maskmoney/js/jquery.maskMoney.min.js"></script>
                    <?php break;
                case "user": ?>
                    <script src="../../lib/personal/js/user.js"></script>
                    <?php break;
            endswitch; ?>

            <script>
                var dtables = $('#tables');
            </script>
    </body>
</html>