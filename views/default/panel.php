
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">NAVEGAÇÃO</li>
                        <li<?php if($_SESSION['page'] === "dashboard") echo ' class="active"'; ?>>
                            <a href="/">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "locator") echo ' class="active"'; ?>>
                            <a href="/locator">
                                <i class="fa fa-black-tie"></i> <span>Locador</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "renter") echo ' class="active"'; ?>>
                            <a href="/renter">
                                <i class="fa fa-user"></i> <span>Locatário</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "immobile") echo ' class="active"'; ?>>
                            <a href="/immobile">
                                <i class="fa fa-home"></i> <span>Imóvel</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "contract") echo ' class="active"'; ?>>
                            <a href="/contract">
                                <i class="glyphicon glyphicon-list-alt"></i> <span>Contrato</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "discount") echo ' class="active"'; ?>>
                            <a href="/discount">
                                <i class="fa fa-minus-square"></i> <span>Desconto</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "receipt") echo ' class="active"'; ?>>
                            <a href="/receipt">
                                <i class="fa fa-file-text"></i> <span>Recibo</span>
                            </a>
                        </li>
                        <li<?php if($_SESSION['page'] === "user") echo ' class="active"'; ?>>
                            <a href="/user">
                                <i class="fa fa-users"></i> <span>Usuários</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
