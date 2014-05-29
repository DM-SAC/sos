<!DOCTYPE html>
<html lang="es">
<head>
  <title><?= isset($this->titulo)?$this->titulo:''; ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SOS">
  <meta name="author" content="DM S.A.C.">
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>bootstrap.css" /> 
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>real_estate.css" />
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>jquery.aw-showcase/style.css" />
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>badger/badger.min.css" />
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>sticky/sticky.min.css" /> 
  <link rel="icon" type="image/png" href="<?= $_layoutParams['ruta_img']?>favicon.ico" />   
  
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
      
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/jquery.aw-showcase/jquery.aw-showcase.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/bootstrap.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/badger/badger.min.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/sticky/sticky.min.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/portamento-min.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/global.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/jquery.validate.js"></script>
        
    <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
  <? if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
      <? foreach($_layoutParams['js'] as $layout): ?>
          <script src="<?=$layout?>" type="text/javascript"></script>
      <? endforeach; ?>
  <? endif; ?>
    
</head>

<body>
 <div class="container">
  <div class="row"><!-- start header -->
    <div class="span4 logo">
      <a href="<?= BASE_URL;?>inicio">
      <div class="row">
        <div class="span1">
          <img src="<?= $_layoutParams['ruta_img']?>Home.jpg" alt="Logo"/>
        </div>
        <div class="span3">
          <h1><small>Administración</small><br /><?=APP_NAME?></h1>
        </div>
      </div> 
      </a>
    </div>      
    <div class="span4 customer_service pull-right text-right"></div>
  </div><!-- end header -->
        
  <div class="row"><!-- start nav -->
    <div class="span12">
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <div class="nav-collapse">
             <ul class="nav">

              <?php if( (Session::get('autenticado')) && (Session::get('tipoId'))=='1'):?>

                <li><a href="<?= BASE_URL; ?>inicio" class="first">INICIO</a></li>
                <li><a href="<?= BASE_URL; ?>policia" class="first">POLICÍAS</a></li>
                <li><a href="<?= BASE_URL; ?>bombero" class="first">BOMBEROS</a></li>
                <li><a href="<?= BASE_URL; ?>cliente" class="first">APP-USUARIO</a></li>
                <li><a href="<?= BASE_URL; ?>alerta" class="first">ALERTAS</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['usuario']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL; ?>usuario/detalle/<?=Session::get('id')?>">Mi Cuenta</a></li>

                        <li><a href="<?= BASE_URL; ?>inicio/cambiar">Cambiar contraseña</a></li>
                        <li><a href="<?= BASE_URL; ?>login/cerrar">Cerrar Sesión</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if( (Session::get('autenticado')) && (Session::get('tipoId'))=='2'):?>
                
                <li><a href="<?= BASE_URL; ?>inicio" class="first">INICIO</a></li>
                <li><a href="<?= BASE_URL; ?>bombero" class="first">BOMBEROS</a></li>
                <li><a href="<?= BASE_URL; ?>bombero/alertas" class="first">ALERTAS</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['usuario']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL; ?>bombero/detalle/<?=Session::get('id')?>">Mi Cuenta</a></li>
                        <li><a href="<?= BASE_URL; ?>inicio">Estadísticas</a></li>
                        <li><a href="<?= BASE_URL; ?>login/cerrar">Cerrar Sesión</a></li>
                    </ul>
                </li>
                <?php endif; ?>


                <?php if( (Session::get('autenticado')) && (Session::get('tipoId'))=='3'):?>
                
                <li><a href="<?= BASE_URL; ?>inicio" class="first">INICIO</a></li>
                <li><a href="<?= BASE_URL; ?>policia" class="first">POLICÍAS</a></li>
                <li><a href="<?= BASE_URL; ?>policia/alertas" class="first">ALERTAS</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['usuario']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL; ?>policia/detalle/<?=Session::get('id')?>">Mi Cuenta</a></li>
                        <li><a href="<?= BASE_URL; ?>inicio">Estadísticas</a></li>
                        <li><a href="<?= BASE_URL; ?>login/cerrar">Cerrar Sesión</a></li>
                    </ul>
                </li>
                <?php endif; ?>
              </ul>
            </div><!-- /.nav-collapse -->
          </div>
        </div><!-- /navbar-inner -->
      </div><!-- /navbar -->
    </div>
  </div><!-- end nav -->      