
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Cadastar Novo Locador
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/locator"><i class="fa fa-black-tie"></i> Locador</a></li>
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
                                    <form id="frmLocator" action="/locator/create" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="desName">Nome Completo:</label>
                                                        <input type="text" name="desName" class="form-control" id="desName" maxlength="100" placeholder="Nome Completo" autofocus
                                                        <?php if (!empty($data)): ?> value="<?= $data['desName'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idNation">Nascionalidade:</label>
                                                        <select name="idNation" id="idNation" class="form-control select">
                                                            <?php foreach ($nationality as $item): ?>
                                                            <optgroup label="<?= $item['desNation'] ?>"></optgroup>
                                                            <option value="<?= $item['idNation'] ?>" <?php if ($item['desNationality'] === "Brasileiro(a)"): ?> selected <?php endif; ?>><?= $item['desNationality'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idMaritalStatus">Estado Civil:</label>
                                                        <select name="idMaritalStatus" id="idMaritalStatus" class="form-control select">
                                                            <?php foreach ($maritalStatus as $item): ?>
                                                                <option value="<?= $item['idMaritalStatus'] ?>" <?php if ($item['desMaritalStatus'] === "Solteiro(a)"): ?> selected <?php endif; ?>><?= $item['desMaritalStatus'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="desProfession">Profissão:</label>
                                                        <input type="text" name="desProfession" class="form-control" maxlength="100" id="desProfession" placeholder="Profissão"
                                                            <?php if (!empty($data)): ?> value="<?= $data['desProfession'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desRG">RG:</label>
                                                        <input type="tel" name="desRG" class="form-control" maxlength="20" id="desRG" placeholder="RG"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desRG'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="desCPF">CPF:</label>
                                                        <input type="tel" name="desCPF" class="form-control" id="desCPF" placeholder="CPF"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desCPF'] ?>" <?php endif; ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="desZipCode">CEP:</label>
                                                    <input type="tel" name="desZipCode" id="desZipCode" class="form-control" placeholder="CEP"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desZipCode'] ?>" <?php endif; ?>>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="desAddress">Endereço:</label>
                                                    <input type="text" name="desAddress" id="desAddress" class="form-control" placeholder="Endereço"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desAddress'] ?>" <?php endif; ?>>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <label for="desNumber">Nº:</label>
                                                    <input type="text" name="desNumber" id="desNumber" class="form-control" placeholder="Nº"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desNumber'] ?>" <?php endif; ?>>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="desDistrict">Bairro:</label>
                                                    <input type="text" name="desDistrict" id="desDistrict" class="form-control" placeholder="Bairro"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desDistrict'] ?>" <?php endif; ?>>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="desCity">Cidade:</label>
                                                    <input type="text" name="desCity" id="desCity" class="form-control" placeholder="Cidade"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desCity'] ?>" <?php endif; ?>>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="desState">UF:</label>
                                                    <input type="text" name="desState" id="desState" class="form-control" placeholder="UF"
                                                        <?php if (!empty($data)): ?> value="<?= $data['desState'] ?>" <?php endif; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Cadastrar</button>
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