<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?php echo base_url(); ?>/assets/backend/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>/assets/backend/plugins/prism/prism.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/backend/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/backend/css/propio.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/assets/backend/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/backend/vue/vue/vue.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/backend/vue/axios/axios.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/backend/vue/pagination/pagination.js"></script>
    <script src="<?php echo base_url(); ?>/assets/backend/vue/vue-column-sortable.js"></script>
    <script src="<?php echo base_url(); ?>/assets/backend/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/backend/js/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Noticias</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                     
                    <li class="nav-item">
                        <?php
                        if(!isset($this->session->user_id) && empty($this->session->user_id))
                        { ?>
                           <a class="nav-link"  v-bind:href="'../Principal/login/'">Login</a>
                       <?php }
                        ?> 
                        
                    </li>
                    <?php
                        if(isset($this->session->user_id) && !empty($this->session->user_id))
                        {?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $this->session->nombre.' '.$this->session->apellidop; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          
                        <a class="dropdown-item" href="<?= base_url('/welcome/logoute') ?>">Salir</a> 
                        </div>
                    </li>
                    <?php } ?>
                   
                </ul>
                
                <div class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" ref="textbuscar" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" @click="buscarNoticias()">Buscar</button>
                </div>
            </div>
        </nav>
        <div class="container">
            <br>
            <div v-for="(imagen2,index2) in noticias"> 
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                            <div class="card-body d-flex flex-column align-items-start">
                                <strong class="d-inline-block mb-2 text-primary">{{imagen2.titulo}}</strong>

                                <div class="mb-1 text-muted small">{{imagen2.fecharegistro}}</div>
                                <p class="card-text mb-auto text-justify" v-html="imagen2.contenido">.</p>
                               
                                <a class="btn btn-outline-primary btn-sm" role="button" style="margin-bottom: 12px;"  v-bind:href="'./leer/'+ imagen2.idnoticia">Seguir leyendo</a>
                                

                            </div>
                            <img v-if="imagen2.imagenes != ''" class="card-img-right flex-auto d-none d-lg-block" alt="Thumbnail [200x250]" v-bind:src="url_image+ imagen2.imagenes[0].nombreimagen" style="width: 200px; height: 250px;">
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div v-if="sinresultado" class="text-center">
                <h4>Sin resultado de busqueda</h4>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>/assets/backend//plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo base_url(); ?>/assets/backend//plugins/bootstrap/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/backend/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo base_url(); ?>/assets/backend/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url(); ?>/assets/backend/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?php echo base_url(); ?>/assets/backend/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="<?php echo base_url(); ?>/assets/backend/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/backend/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="<?php echo base_url(); ?>/assets/backend/js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/backend/app-vue/appprincipal.js"></script>

<script src="<?php echo base_url(); ?>/assets/backend/plugins/styleswitcher/jQuery.style.switcher.js"></script>


</html>