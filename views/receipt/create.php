
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Cadastar Novo Recibo
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/receipt"><i class="fa fa-file-text"></i> Recibo</a></li>
                        <li class="active"><i class="fa fa-plus"></i> Novo Registro</li>
                    </ol>
                </section>

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
                                    <h3 class="box-title">Novo Registro</h3>
                                </div>
                                <!-- box-body -->
                                <div class="box-body">
                                    <!-- form start -->
                                    <form id="frmReceipt" action="/receipt/create" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desCode">Código:</label>
                                                        <input type="text" name="desCode" class="form-control text-center" style="font-size: 20px; font-weight: bold" id="desCode" value="<?= $codigo ?>" maxlength="10" placeholder="Código" readonly
                                                        <?php if (!empty($data)): ?> value="<?= $data['receiptCode'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="idContract">Contrato:</label>
                                                        <select name="idContract" id="idContract" class="form-control select" autofocus>
                                                        <?php foreach ($contract as $item): ?>
                                                            <option value="<?= $item['desCode'] ?>"<?php if (!empty($data) && $data['contractCode'] === $item['desCode']): ?>selected<?php endif; ?>><?= $item['desCode'] . "/" . $item['desRenter'] ?></option>
                                                        <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desPaymentInterest">Juros:</label>
                                                        <input type="number" name="desPaymentInterest" id="desPaymentInterest" min="1" placeholder="Juros" class="form-control"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desPaymentInterest'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desMonth">Mês:</label>
                                                        <input type="month" name="desMonth" id="desMonth" class="form-control" placeholder="Mês">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="dtSignature">Data Assinatura:</label>
                                                        <input type="date" name="dtSignature" class="form-control" id="dtSignature" placeholder="Data Assinatura"
                                                            <?php if (!empty($data)): ?> value="<?= $data['dtInitial'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Cadastrar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/receipt'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->