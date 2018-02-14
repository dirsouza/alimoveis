
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
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desCode">Código:</label>
                                                        <input type="text" name="desCode" class="form-control text-center codeReceipt" id="desCode" value="<?= str_pad($codigo, 4, "0",STR_PAD_LEFT) ?>" maxlength="10" placeholder="Código" readonly autofocus
                                                        <?php if (!empty($data)): ?> value="<?= $data['desCode'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="idContract">Contrato:</label>
                                                        <select name="idContract" id="idContract" class="form-control select">
                                                            <option>Selecione</option>
                                                        <?php foreach ($contract as $item): ?>
                                                            <option value="<?= $item['idContract'] ?>"<?php if (!empty($data) && $data['contractCode'] === $item['desCode']): ?>selected<?php endif; ?>><?= $item['desCode'] . "/" . $item['desRenter'] ?></option>
                                                        <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desFined">Multa:</label>
                                                        <input type="text" name="desFined" id="desFined" class="form-control money" placeholder="R$ 0,00"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desFined'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desInterest">Juros:</label>
                                                        <input type="text" name="desInterest" id="desInterest" class="form-control money" placeholder="R$ 0,00"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desInterest'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="desPortions">Desconto:</label>
                                                        <select name="desPortions[]" id="desPortions" class="form-control select" disabled multiple data-placeholder="Selecione"></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desMonth">Mês:</label>
                                                        <input type="text" name="desMonth" id="desMonth" class="form-control" placeholder="Mês" style="text-align: center">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desValue">Total:</label>
                                                        <input type="text" name="desValue" id="desValue" class="form-control money" style="font-weight: bold" placeholder="R$ 0,00" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="desNote">Anotações:</label>
                                                        <textarea name="desNote" id="desNote" cols="1" rows="3" maxlength="254" class="form-control" placeholder="Anotações" onclick="this.select()"></textarea>
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