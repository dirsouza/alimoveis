
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Lista de Recibos
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class="fa fa-file-text"></i> Recibo</li>
                    </ol>
                </section>

                <!-- Message -->
                <?php if (!empty($msg)): ?>
                    <div id="msg" <?= $msg ?>></div>
                <?php endif; ?>

                <!-- Error Dialog -->
                <?php if (isset($_SESSION['error'])): ?>
                <section class="content-header modal-dialog" id="error-alert">
                    <div class="row">
                        <div class="alert alert-<?= $_SESSION['error']['type'] ?> alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa <?= $_SESSION['error']['ico'] ?>"></i> <?= $_SESSION['error']['title'] ?></h4>
                            <?= $_SESSION['error']['msg']; unset($_SESSION['error']) ?>
                        </div>
                    </div>
                </section>
                <?php endif; ?>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- box -->
                            <div class="box box-primary">
                                <!-- box-header -->
                                <div class="box-header with-border">
                                    <a href="/receipt/create" class="btn btn-flat bg-olive">Novo Recibo</a>
                                </div>
                                <!-- box-body -->
                                <div class="box-body">
                                    <!-- table -->
                                    <table id="tables" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="3%" class="text-center">#</th>
                                            <th>Contrato/Imóvel</th>
                                            <th>Juros</th>
                                            <th>Mês</th>
                                            <th width="10%" class="text-center">Dt. Assinatura</th>
                                            <th width="10%" class="text-center">Pago</th>
                                            <th width="10%" class="text-center">Dt. Registro</th>
                                            <th data-orderable="false" width="10%">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($receipt as $item): ?>
                                        <tr>
                                            <td class="text-center"><?= $item['receiptCode'] ?></td>
                                            <td><?= $item['contractCode'] ?></td>
                                            <td><?= $item['desPaymentInterest'] ?></td>
                                            <td><?= $item['desMonth'] ?></td>
                                            <td><?= $item['dtSignature'] ?></td>
                                            <td><?= $item['desPayment'] ?></td>
                                            <td><?= $item['dtRegister'] ?></td>
                                            <td class="text-center">
                                                <a href="/receipt/receipt/<?= $item['desCode'] ?>" class="btn bg-purple btn-xs btn-flat" target="_blank" data-toggle="tooltip" data-placement="top" title data-original-title="Recibo">
                                                    <i class="fa fa-file-text"></i>
                                                </a>
                                                <a href="/receipt/update/<?= $item['idReceipt'] ?>" class="btn btn-primary btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title data-original-title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="/receipt/<?= $item['idReceipt'] ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title data-original-title="Excluir">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->