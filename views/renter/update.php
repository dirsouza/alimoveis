
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Atualizar Dados do Locador
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/renter"><i class="fa fa-black-tie"></i> Locatário</a></li>
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
                                    <form id="frmRenter" action="/renter/update/<?= $renter['idRenter'] ?>" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desName">Nome Completo:</label>
                                                        <input type="text" name="desName" class="form-control" id="desName" maxlength="100" value="<?= $renter['desName'] ?>" placeholder="Nome Completo" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idNation">Nascionalidade:</label>
                                                        <select name="idNation" id="idNation" class="form-control select">
                                                            <?php foreach ($nationality as $item): ?>
                                                            <optgroup label="<?= $item['desNation'] ?>"></optgroup>
                                                            <option value="<?= $item['idNation'] ?>" <?php if ($item['idNation'] === $renter['idNation']): ?> selected <?php endif; ?>><?= $item['desNationality'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idMaritalStatus">Estado Civil:</label>
                                                        <select name="idMaritalStatus" id="idMaritalStatus" class="form-control select">
                                                            <?php foreach ($maritalStatus as $item): ?>
                                                                <option value="<?= $item['idMaritalStatus'] ?>" <?php if ($item['idMaritalStatus'] === $renter['idMaritalStatus']): ?> selected <?php endif; ?>><?= $item['desMaritalStatus'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desProfession">Profissão:</label>
                                                        <input type="text" name="desProfession" class="form-control" maxlength="100" id="desProfession" value="<?= $renter['desProfession'] ?>" placeholder="Profissão">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desRG">RG:</label>
                                                        <input type="text" name="desRG" class="form-control" maxlength="20" id="desRG" value="<?= $renter['desRG'] ?>" placeholder="RG">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desCPF">CPF:</label>
                                                        <input type="text" name="desCPF" class="form-control" id="desCPF" value="<?= $renter['desCPF'] ?>" placeholder="CPF" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Atualizar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/renter'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->