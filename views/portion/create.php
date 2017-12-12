
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Cadastar Parcelas
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/" class="disabled"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="/discount" class="disabled"><i class="fa fa-minus-square"></i> Desconto</a></li>
                        <li class="active"><i class="glyphicon glyphicon-tasks"></i> Parcelas</li>
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
                                    <h3 class="box-title">Parcelas</h3>
                                </div>
                                <!-- box-body -->
                                <div class="box-body">
                                    <!-- form start -->
                                    <form id="frmPortion" action="/discount/create/portion" method="post">
                                        <input type="hidden" name="idDiscount" value="<?=$discount['idDiscount']?>">
                                        <!-- box body -->
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="desDescription">Descrição:</label>
                                                        <input type="text" class="form-control" value="<?=$discount['desDescription']?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idContract">Contrato:</label>
                                                        <input type="text" class="form-control" value="<?=$contract['desCode']?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="desValue">Valor:</label>
                                                        <input type="text" class="form-control" value="<?="R$ " . number_format($discount['desValue'], 2, ",", ".")?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table">
                                                        <thead>
                                                        <tr style="background-color: #3c8dbc; color: #FFFFFF">
                                                            <th class="text-center" width="20%">Parcela Nº</th>
                                                            <th class="text-center">Vencimento</th>
                                                            <th class="text-center">Valor</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $n = 0;
                                                        $day = date('d', strtotime($contract['dtInitial']));
                                                        $month = date('m', strtotime($discount['dtRegister']));
                                                        $year = date('Y', strtotime($discount['dtRegister']));
                                                        $date = date('Y-m-d', strtotime('+1 month', strtotime($year."-".$month."-".$day)));
                                                        $portion = $discount['desPortion'];
                                                        $value = $discount['desValue'];
                                                        $valueSet = 0;
                                                        if ($portion > 1) {
                                                            if ($value > 100) {
                                                                $valuePortion = 100;
                                                            } else {
                                                                $valuePortion = $value/$portion;
                                                            }
                                                        } else {
                                                            $valuePortion = $value;
                                                        }
                                                        ?>
                                                        <?php for ($i = 0; $i < (int)$discount['desPortion'] ; $i++): ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" name="desPortion[]" id="desPortion" class="form-control text-center" value="<?=str_pad($n += 1, 3, "0", STR_PAD_LEFT)?>" readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="date" name="dtMaturity[]" id="dtMaturity" class="form-control" value="<?=$date?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" name="desValue[]" class="form-control desValue" value="<?="R$ " . number_format($valuePortion, 2, ",", ".")?>" placeholder="R$ 0,00">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $date = date('Y-m-d', strtotime('+1 month', strtotime($date)));
                                                            $valueSet += $valuePortion;
                                                            if ($i < ($portion - 2) && ($value - $valueSet) > 100) {
                                                                $valuePortion = 100;
                                                            } else {
                                                                if ($i === ($portion - 1) && ($value - $valueSet) > 100) {
                                                                    $valuePortion = $value - $valueSet;
                                                                } else {
                                                                    $valuePortion = $value - $valueSet;
                                                                }
                                                            }
                                                        ?>
                                                        <?php endfor; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box footer -->
                                        <div class="box-footer modal-footer">
                                            <button type="submit" class="btn btn-flat btn-primary">Cadastrar</button>
                                            <button type="button" class="btn btn-flat bg-orange" onclick="javascript: location.href='/discount/update/<?=$discount['idDiscount']?>'">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->