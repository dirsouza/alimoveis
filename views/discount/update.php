
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
                                    <form id="frmDiscount" action="/discount/update/<?= $locator['idLocator'] ?>" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desDescription">Descrição:</label>
                                                        <input type="text" name="desDescription" class="form-control" id="desDescription" maxlength="256" value="<?= $discount['desDescription'] ?>" placeholder="Descrição" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idNation">Nascionalidade:</label>
                                                        <select name="idNation" id="idNation" class="form-control select">
                                                            <?php foreach ($nationality as $item): ?>
                                                            <optgroup label="<?= $item['desNation'] ?>"></optgroup>
                                                            <option value="<?= $item['idNation'] ?>" <?php if ($item['idNation'] === $discount['idNation']): ?> selected <?php endif; ?>><?= $item['desNationality'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idMaritalStatus">Estado Civil:</label>
                                                        <select name="idMaritalStatus" id="idMaritalStatus" class="form-control select">
                                                            <?php foreach ($maritalStatus as $item): ?>
                                                                <option value="<?= $item['idMaritalStatus'] ?>" <?php if ($item['idMaritalStatus'] === $discount['idMaritalStatus']): ?> selected <?php endif; ?>><?= $item['desMaritalStatus'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="desProfession">Profissão:</label>
                                                        <input type="text" name="desProfession" class="form-control" maxlength="100" id="desProfession" value="<?= $discount['desProfession'] ?>" placeholder="Profissão">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desRG">RG:</label>
                                                        <input type="text" name="desRG" class="form-control" maxlength="20" id="desRG" value="<?= $discount['desRG'] ?>" placeholder="RG">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desCPF">CPF:</label>
                                                        <input type="text" name="desCPF" class="form-control" id="desCPF" value="<?= $discount['desCPF'] ?>" placeholder="CPF" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desZipCode">CEP:</label>
                                                        <input type="text" name="desZipCode" class="form-control" id="desZipCode" value="<?= $discount['desZipCode'] ?>" placeholder="CEP">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desAddress">Endereço:</label>
                                                        <input type="text" name="desAddress" class="form-control" id="desAddress" value="<?= $discount['desAddress'] ?>" placeholder="Endereço">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desNumber">Nº:</label>
                                                        <input type="text" name="desNumber" id="desNumber" class="form-control" value="<?= $discount['desNumber'] ?>" placeholder="Nº">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desDistrict">Bairro:</label>
                                                        <input type="text" name="desDistrict" id="desDistrict" class="form-control" value="<?= $discount['desDistrict'] ?>" placeholder="Bairro">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="desCity">Cidade:</label>
                                                        <input type="text" name="desCity" id="desCity" class="form-control" value="<?= $discount['desCity'] ?>" placeholder="Cidade">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="desState">UF:</label>
                                                        <input type="text" name="desState" id="desState" class="form-control" value="<?= $discount['desState'] ?>" placeholder="UF">
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