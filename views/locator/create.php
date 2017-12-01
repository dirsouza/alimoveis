
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
                                    <form action="/locator/create" method="post">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desName">Nome Completo:</label>
                                                        <input type="text" class="form-control" id="desName" placeholder="Nome Completo" autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idNation">Nascionalidade:</label>
                                                        <select name="idNation" id="idNation" class="form-control select">
                                                            <option value="1">Alemão(ã)</option>
                                                            <option value="2">Americano(a)</option>
                                                            <option value="3" selected>Brasileiro(a)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idMaritalStatus">Estado Civil:</label>
                                                        <select name="idMaritalStatus" id="idMaritalStatus" class="form-control select">
                                                            <option value="1" selected>Solteiro(a)</option>
                                                            <option value="2">Casado(a)</option>
                                                            <option value="3">Divorciado(a)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desProfession">Profissão:</label>
                                                        <input type="text" class="form-control" id="desProfession" placeholder="Profissão">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desRG">RG:</label>
                                                        <input type="text" class="form-control" id="desRG" placeholder="RG">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desCPF">CPF:</label>
                                                        <input type="text" class="form-control" id="desCPF" placeholder="CPF">
                                                    </div>
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