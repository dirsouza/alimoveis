
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Atualizar Dados do Contrato
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/renter"><i class="glyphicon glyphicon-list-alt"></i> Contrato</a></li>
                        <li class="active"><i class="fa fa-pencil"></i> Atualizar Dados do Contrato</li>
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
                                    <form id="frmContract" action="/contract/update/<?= $contract['idContract'] ?>" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desCode">Código:</label>
                                                        <input type="text" name="desCode" class="form-control text-center" style="font-size: 28px" id="desCode" value="<?= $contract['desCode'] ?>" maxlength="10" placeholder="Código" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="idLocator">Locador:</label>
                                                        <select name="idLocator" id="idLocator" class="form-control select" autofocus>
                                                            <?php foreach ($locator as $item): ?>
                                                                <option value="<?= $item['idLocator'] ?>"<?php if ($item['idLocator'] === $contract['idLocator']): ?>selected<?php endif; ?>><?= $item['desName'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="idRenter">Locatário:</label>
                                                        <select name="idRenter" id="idRenter" class="form-control select">
                                                            <?php foreach ($renter as $item): ?>
                                                                <option value="<?= $item['idRenter'] ?>"<?php if ($item['idRenter'] === $contract['idRenter']): ?>selected<?php endif; ?>><?= $item['desName'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="idImmobile">Imóvel:</label>
                                                        <select name="idImmobile" id="idImmobile" class="form-control select">
                                                            <?php foreach ($immobile as $item): ?>
                                                                <option value="<?= $item['idImmobile'] ?>"<?php if ($item['idImmobile'] === $contract['idImmobile']): ?>selected<?php endif; ?>><?= $item['desDescription'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desDeadline">Prazo:</label>
                                                        <input type="number" name="desDeadline" class="form-control" id="desDeadline" value="<?= $contract['desDeadline'] ?>" min="1" placeholder="Prazo">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="dtInitial">Data Inicial:</label>
                                                        <input type="date" name="dtInitial" class="form-control" id="dtInitial" value="<?= $contract['dtInitial'] ?>" placeholder="Data Inicial">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="dtFinal">Data Final:</label>
                                                        <input type="date" name="dtFinal" class="form-control" id="dtFinal" value="<?= $contract['dtFinal'] ?>" placeholder="Data Final">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desValue">Valor:</label>
                                                        <input type="text" name="desValue" class="form-control" id="desValue" value="<?= "R$ " . number_format($contract['desValue'],2,",",".") ?>" placeholder="R$ 0,00">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Atualizar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/contract'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->