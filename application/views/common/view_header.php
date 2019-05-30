<header class="main-header">
  <a href="<?php echo base_url('/painel/home') ?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b>S</b>iG</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>SiGA</b></span>
  </a>
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
      <div class="navbar-custom-menu">
          <!--div class="navbar-header">
              <a class="navbar-brand" href="<?php echo base_url('/painel/home') ?>"><b>SiGA</b></a>
          </div-->
          <div class="collapse navbar-collapse" id="app-navbar-collapse">
                      <!-- Left Side Of Navbar -->


                      <!-- Right Side Of Navbar -->
                      <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                              <i class="far fa-user"></i>&nbsp;&nbsp;<?php echo $nome_usuario; ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">

                                <li>
                                    <a href="<?php echo base_url('/painel/logout') ?>">
                                        <i class="fas fa-sign-out-alt"></i> Sair
                                    </a>
                                </li>

                            </ul>
                        </li>
                      </ul>
                  </div>
            </div>
  </nav>
</header>
