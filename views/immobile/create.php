
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Cadastar Novo Imóvel
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/immobile"><i class="fa fa-home"></i> Imóvel</a></li>
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
                                    <form id="frmImmobile" action="/immobile/create" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desDescription">Descrição do Imóvel:</label>
                                                        <input type="text" name="desDescription" class="form-control" id="desDescription" maxlength="100" placeholder="Descrição do Imóvel" autofocus
                                                        <?php if (!empty($data)): ?> value="<?= $data['desDescription'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desZipCode">CEP:</label>
                                                        <input type="tel" name="desZipCode" class="form-control" id="desZipCode" placeholder="CEP"
                                                            <?php if (!empty($data)): ?> value="<?= $data['desZipCode'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desAddress">Endereço:</label>
                                                        <input type="text" name="desAddress" class="form-control" id="desAddress" maxlength="100" placeholder="Endereço"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desAddress'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desNumber">Número:</label>
                                                        <input type="text" name="desNumber" class="form-control" id="desNumber" maxlength="10" placeholder="Nº"
                                                            <?php if (!empty($data)): ?> value="<?= $data['desNumber'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desDistrict">Bairro:</label>
                                                        <input type="text" name="desDistrict" class="form-control" maxlength="100" id="desDistrict" placeholder="Bairro"
                                                            <?php if (!empty($data)): ?> value="<?= $data['desDistrict'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desCity">Cidade:</label>
                                                        <input type="text" name="desCity" class="form-control" maxlength="100" id="desCity" placeholder="Cidade"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desCity'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desState">UF:</label>
                                                        <input type="text" name="desState" class="form-control text-uppercase" maxlength="2" id="desState" placeholder="UF"
                                                            <?php if (!empty($data)): ?> value="<?= $data['desState'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Cadastrar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/immobile'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->