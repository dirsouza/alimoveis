
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Lista de Descontos
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class="fa fa-minus-square"></i> Desconto</li>
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
                                    <a href="/discount/create" class="btn btn-flat bg-olive">Novo Desconto</a>
                                </div>
                                <!-- box-body -->
                                <div class="box-body">
                                    <!-- table -->
                                    <table id="tables" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="3%" class="text-center">#</th>
                                            <th>Descrição</th>
                                            <th width="30%">Contrato/Imóvel</th>
                                            <th width="13%">Desconto (R$)</th>
                                            <th width="10%" class="text-center">Dt. Registro</th>
                                            <th data-orderable="false" width="7%">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($discount as $item): ?>
                                        <tr>
                                            <td class="text-center"><?= $item['idDiscount'] ?></td>
                                            <td><?= $item['desDescription'] ?></td>
                                            <td><?= $item['contractCode']."/".$item['immobileDescription'] ?></td>
                                            <td class="text-right"><?= number_format($item['desValue'], 2, ",", ".") ?></td>
                                            <td class="text-center"><?= date('d/m/Y', strtotime($item['dtRegister'])) ?></td>
                                            <td class="text-center">
                                                <a href="/discount/update/<?= $item['idDiscount'] ?>" class="btn btn-primary btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title data-original-title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="/discount/<?= $item['idDiscount'] ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs btn-flat" data-toggle="tooltip" data-placement="top" title data-original-title="Excluir">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                        <?php if (!empty($totalValues)): ?>
                                        <tbody class="footer">
                                            <tr>
                                                <th colspan="3" class="text-right">Total Geral</th>
                                                <th class="text-right"><?=number_format($totalValues, 2, ",", ".")?></th>
                                                <th colspan="2">&nbsp;</th>
                                            </tr>
                                        </tbody>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->