
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Atualizar Dados do Locador
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/locator"><i class="fa fa-black-tie"></i> Locador</a></li>
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
                                    <form id="frmLocator" action="/locator/update/<?= $locator['idLocator'] ?>" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="desName">Nome Completo:</label>
                                                        <input type="text" name="desName" class="form-control" id="desName" maxlength="100" value="<?= $locator['desName'] ?>" placeholder="Nome Completo" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idNation">Nascionalidade:</label>
                                                        <select name="idNation" id="idNation" class="form-control select">
                                                            <?php foreach ($nationality as $item): ?>
                                                            <optgroup label="<?= $item['desNation'] ?>">
                                                                <option value="<?= $item['idNation'] ?>" <?php if ($item['idNation'] === $locator['idNation']): ?> selected <?php endif; ?>><?= $item['desNationality'] ?></option>
                                                            </optgroup>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idMaritalStatus">Estado Civil:</label>
                                                        <select name="idMaritalStatus" id="idMaritalStatus" class="form-control select">
                                                            <?php foreach ($maritalStatus as $item): ?>
                                                                <option value="<?= $item['idMaritalStatus'] ?>" <?php if ($item['idMaritalStatus'] === $locator['idMaritalStatus']): ?> selected <?php endif; ?>><?= $item['desMaritalStatus'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="desProfession">Profissão:</label>
                                                        <input type="text" name="desProfession" class="form-control" maxlength="100" id="desProfession" value="<?= $locator['desProfession'] ?>" placeholder="Profissão">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desRG">RG:</label>
                                                        <input type="tel" name="desRG" class="form-control" maxlength="20" id="desRG" value="<?= $locator['desRG'] ?>" placeholder="RG">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desCPF">CPF:</label>
                                                        <input type="tel" name="desCPF" class="form-control" id="desCPF" value="<?= $locator['desCPF'] ?>" placeholder="CPF" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desZipCode">CEP:</label>
                                                        <input type="tel" name="desZipCode" class="form-control" id="desZipCode" value="<?= $locator['desZipCode'] ?>" placeholder="CEP">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desAddress">Endereço:</label>
                                                        <input type="text" name="desAddress" class="form-control" id="desAddress" value="<?= $locator['desAddress'] ?>" placeholder="Endereço">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desNumber">Nº:</label>
                                                        <input type="text" name="desNumber" id="desNumber" class="form-control" value="<?= $locator['desNumber'] ?>" placeholder="Nº">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desDistrict">Bairro:</label>
                                                        <input type="text" name="desDistrict" id="desDistrict" class="form-control" value="<?= $locator['desDistrict'] ?>" placeholder="Bairro">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desCity">Cidade:</label>
                                                        <input type="text" name="desCity" id="desCity" class="form-control" value="<?= $locator['desCity'] ?>" placeholder="Cidade">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desState">UF:</label>
                                                        <input type="text" name="desState" id="desState" class="form-control" value="<?= $locator['desState'] ?>" placeholder="UF">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Atualizar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/locator'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->