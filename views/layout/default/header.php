<!DOCTYPE html>
<html lang="es">
<head>
  <title><?= isset($this->titulo)?$this->titulo:''; ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SOS Emergencias">
  <meta name="author" content="DM S.A.C.">
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>bootstrap.css" /> 
  <link rel="stylesheet" href="<?= $_layoutParams['ruta_css'];?>real_estate.css" />
  <link rel="icon" type="image/png" href="<?= $_layoutParams['ruta_img']?>favicon.ico" />   
    
      
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/jquery.validate.js"></script>
<!--
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/bootstrap.js"></script>

<script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?region=PE,sensor=true">
</script>
  <script type="text/javascript" src="<?= BASE_URL; ?>public/js/gmaps.js"></script>
-->
  
    <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
  <? if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
      <? foreach($_layoutParams['js'] as $layout): ?>
          <script src="<?=$layout?>" type="text/javascript"></script>
      <? endforeach; ?>
  <? endif; ?>

<script type="text/javascript">
  function confirmarSesion(){
  if(confirm('¿Está seguro de cerrar sesión?'))
    return true;
  else
    return false;
}
</script>
</head>

<body class="fondo<?=Session::get('tipoId')?>">
 <div class="container general">
  <div class="row"><!-- start header -->
    <div class="span4 logo">
      <a href="<?= BASE_URL;?>inicio">
      <div class="row">
        <div class="span1">
        <?php if (Session::get('tipoId')==2) :?>
          <img src="<?= $_layoutParams['ruta_img']?>bombero.png" heigth="48" width="48"alt="Logo"/>
        <?php endif;?>
        <?php if (Session::get('tipoId')==3) :?>
          <img src="<?= $_layoutParams['ruta_img']?>policia.png" heigth="48" width="48"alt="Logo"/>
        <?php endif; ?>
        <?php if (Session::get('tipoId')==1) :?>
        <img src="<?= $_layoutParams['ruta_img']?>DM.png" heigth="48" width="48"alt="Logo"/>
        <?php endif; ?>
        </div>
        <div class="span3">
          <h1><small>Central de Emergencias</small><br /><?=APP_NAME?></h1>
        </div>
      </div> 
      </a>
    </div>      
    <?php if( (Session::get('autenticado'))):?>
    <div class="span4 customer_service pull-right text-right">
     <label><p title="<?=Session::get('distrito')?>"><strong><?=Session::get('usuario')?></strong></p></label>
     <a href="<?= BASE_URL;?>login/cerrar" onclick="return confirmarSesion()">Cerrar sesión</a>
    </div>
     <?php endif; ?>
  </div><!-- end header -->
        
  <div class="row"><!-- start nav -->
    <div class="span12">
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <div class="nav-collapse">
             <ul class="nav">
             
              <?php if(isset($_layoutParams['menu'])): ?>
                <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                <?php 
                  if($item && $_layoutParams['menu'][$i]['id'] == $item ){ 
                    $_item_style = 'current'; 
                  } else {
                    $_item_style = '';
                  }
                ?>

                <li><a class="first <?=$_item_style?>" href="<?php echo $_layoutParams['menu'][$i]['enlace']; ?>"><?php  echo $_layoutParams['menu'][$i]['titulo']; ?></a></li>

                <?php endfor; ?>
              <?php endif; ?>
              
              </ul>
            </div><!-- /.nav-collapse -->
          </div>
        </div><!-- /navbar-inner -->
      </div><!-- /navbar -->
    </div>
  </div><!-- end nav -->      