
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Atualizar Dados do Desconto
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/discount"><i class="fa fa-minus-square"></i> Desconto</a></li>
                        <li class="active"><i class="fa fa-pencil"></i> Atualizar Dados do Locador</li>
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
                                    <h3 class="box-title">Atualizar Registro</h3>
                                </div>
                                <!-- box-body -->
                                <div class="box-body">
                                    <!-- form start -->
                                    <form id="frmDiscount" action="/discount/update/<?= $discount['idDiscount'] ?>" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desDescription">Descrição:</label>
                                                        <input type="text" name="desDescription" class="form-control" id="desDescription" maxlength="256" value="<?= $discount['desDescription'] ?>" placeholder="Descrição" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idContract">Contrato/Locatário:</label>
                                                        <select name="idContract" id="idContract" class="form-control select">
                                                            <?php foreach ($contract as $item): ?>
                                                            <option value="<?= $item['idContract'] ?>" <?php if ($discount['idContract'] === $item['idContract']): ?>selected<?php endif; ?>><?= $item['desCode']."/".$item['desRenter'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desValue">Valor:</label>
                                                        <input type="text" name="desValue" class="form-control money" id="desValue" placeholder="R$ 0,00" value="<?="R$ " . number_format($discount['desValue'], 2, ",", ".")?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desPortion">Parcela:</label>
                                                        <input type="number" name="desPortion" class="form-control" id="desPortion" value="<?=$discount['desPortion']?>" min="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Atualizar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/discount'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->