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
    <div id="appcomentario">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Noticias</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <?php
                        if (!isset($this->session->user_id) && empty($this->session->user_id)) { ?>
                            <a class="nav-link" v-bind:href="'../../Principal/login/'">Login</a>
                        <?php }
                        ?>

                    </li>
                    <?php
                    if (isset($this->session->user_id) && !empty($this->session->user_id)) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $this->session->nombre . ' ' . $this->session->apellidop; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?= base_url('/welcome/logoute') ?>">Salir</a>
                            </div>
                        </li>
                    <?php } ?>

                </ul>
 
            </div>
        </nav>
        <div class="container">
            <div class="row">

                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <br><br>
                    <div id="appcomentario">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title text-left" v-html="detallenoticia.titulo"></h2>
                                <h4 class="card-subtitle">
                                    <div v-html="detallenoticia.contenido"></div>
                                </h4>
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-8" class="text-center">
                                        <div class="card">
                                            <div class="card-body">

                                                <img  v-bind:src="url_image + imagenes[0].nombreimagen" class="img-responsive  product" alt="Responsive image" width="40%">
                                                <br>
                                                <div class="text-right">Publicado el: {{detallenoticia.fecharegistro}}</div>
                                                <div class="text-right">Autor: {{detallenoticia.nombre}} {{detallenoticia.apepaterno}} {{detallenoticia.apematerno}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2"></div>
                                </div>
                                <h5>Comentarios</h5>
                                <h4 v-if="comentarios == ''" class="text-center">Sin comentarios registrados</h4>
                                <h6 v-if="comentarios == ''" class="text-center">Pudes ser el primer en comentar</h6>
                                <div v-if="comentarios == ''" class="text-center">
                                    <button class="btn btn-primary" v-if="idusuario != ''" @click="abrirModalRegistrarComentario()">Comentar</button>
                                    <p v-if="idusuario == ''">*Es necesario inciar sesión para comentar.</p>
                                </div>
                                <div class="profiletimeline">
                                    <ul class="listacomentarios">
                        
                                        <li v-for="row  in comentarios">
                                            <hr>
                                            <div class="sl-item">
                                                <div class="sl-left"> <img src="<?php echo base_url(); ?>/assets/backend/images/users/perfil.png" alt="user" class="img-circle" /> </div>
                                                <div class="sl-right">
                                                    <div>
                                                        <span v-if="row.idrol == 2"> <span class="label label-info">Interno</span> {{row.nombre}} {{row.apepaterno}} {{row.apematerno}}</span>
                                                        <span v-else> <span class="label label-success">Externo</span> {{row.unombre}} {{row.uapepaterno}} {{row.uapematerno}}</span>
                                                        <span class="sl-date">{{row.fecharegistro}}</span>
                                                        <p class="m-t-10" v-html="row.comentario"> </p>

                                                    </div>

                                                    <div class="like-comm m-t-20">
                                                        <a v-if="idusuario == row.idusuario && idusuario != ''" @click="eliminarComentario(row.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                        <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row);" v-if="idusuario == row.idusuario && idusuario != ''" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>
                                                        <a v-if="idusuario != ''" @click="abrirModalRegistrar(); selectComentarioReplay(row);" title="Comentar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-mail-forward"></i> Comentar</a>
                                                        <div v-if="row.nodes!=''">
                                                            <ul class="listacomentarios">
                                                                <li v-for="row2  in row.nodes">
                                                                    <hr>
                                                                    <div class="sl-item">
                                                                        <div class="sl-left"> <img src="<?php echo base_url(); ?>/assets/backend/images/users/perfil.png" alt="user" class="img-circle" /> </div>
                                                                        <div class="sl-right">
                                                                            <div><span v-if="row2.idrol == 2"> <span class="label label-info">Interno</span> {{row2.nombre}} {{row2.apepaterno}} {{row2.apematerno}}</span>
                                                                                <span v-else> <span class="label label-success">Externo</span> {{row2.unombre}} {{row2.uapepaterno}} {{row2.uapematerno}}</span>
                                                                                <span class="sl-date">{{row2.fecharegistro}}</span>
                                                                                <p class="m-t-10" v-html="row2.comentario"> </p>

                                                                            </div>
                                                                            <div class="like-comm m-t-20">
                                                                                <a v-if="idusuario == row2.idusuario && idusuario != ''" @click="eliminarComentario(row2.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                                                <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row2);" v-if="idusuario == row2.idusuario && idusuario != ''" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>
                                                                                <a v-if="idusuario != ''" @click="abrirModalRegistrar(); selectComentarioReplay(row2);" title="Comentar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-mail-forward"></i> Comentar</a>

                                                                                <div v-if="row2.nodes!=''">
                                                                                    <ul class="listacomentarios">
                                                                                        <li v-for="row3  in row2.nodes">
                                                                                            <hr>
                                                                                            <div class="sl-item">
                                                                                                <div class="sl-left"> <img src="<?php echo base_url(); ?>/assets/backend/images/users/perfil.png" alt="user" class="img-circle" /> </div>
                                                                                                <div class="sl-right">
                                                                                                    <div><span v-if="row3.idrol == 2"> <span class="label label-info">Interno</span> {{row3.nombre}} {{row3.apepaterno}} {{row3.apematerno}}</span>
                                                                                                        <span v-else> <span class="label label-success">Externo</span> {{row3.unombre}} {{row3.uapepaterno}} {{row3.uapematerno}}</span>
                                                                                                        <span class="sl-date">{{row3.fecharegistro}}</span>
                                                                                                        <p class="m-t-10" v-html="row3.comentario"> </p>

                                                                                                    </div>
                                                                                                    <a v-if="idusuario == row3.idusuario && idusuario != ''" @click="eliminarComentario(row3.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                                                                    <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row3);" v-if="idusuario == row3.idusuario && idusuario != ''" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>
                                                                                                    <a v-if="idusuario != ''" @click="abrirModalRegistrar(); selectComentarioReplay(row3);" title="Comentar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-mail-forward"></i> Comentar</a>

                                                                                                    <div v-if="row3.nodes!=''">
                                                                                                        <ul class="listacomentarios">
                                                                                                            <li v-for="row4  in row3.nodes">
                                                                                                                <hr>
                                                                                                                <div class="sl-item">
                                                                                                                    <div class="sl-left"> <img src="<?php echo base_url(); ?>/assets/backend/images/users/perfil.png" alt="user" class="img-circle" /> </div>
                                                                                                                    <div class="sl-right">
                                                                                                                        <div><span v-if="row4.idrol == 2"> <span class="label label-info">Interno</span> {{row4.nombre}} {{row4.apepaterno}} {{row4.apematerno}}</span>
                                                                                                                            <span v-else> <span class="label label-success">Externo</span> {{row4.unombre}} {{row4.uapepaterno}} {{row4.uapematerno}}</span>
                                                                                                                            <span class="sl-date">{{row4.fecharegistro}}</span>
                                                                                                                            <p class="m-t-10" v-html="row4.comentario"> </p>

                                                                                                                        </div>
                                                                                                                        <a v-if="idusuario == row4.idusuario && idusuario != ''" @click="eliminarComentario(row4.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                                                                                        <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row4);" v-if="idusuario == row4.idusuario && idusuario != ''" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>

                                                                                                                        <!--<div v-if="row3.nodes!=''">
                                                                                            <ul class="listacomentarios">
                                                                                                <li>//row3.nodes</li>
                                                                                            </ul>
                                                                                        </div>-->
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="comentarios != '' &&  idusuario != ''" class="text-left">
                                    <button class="btn btn-primary" @click="abrirModalRegistrarComentario()">Comentar</button>
                                </div>
                                <div v-if="idusuario == ''">
                                    
                                    <h5>*Es necesario inciar sesión para comentar.</h5>
                                </div>
                                
                            </div>
                        </div>

                        <?php include 'modal_comentario.php'; ?>
                    </div>
                </div>
                <div class="col-lg-1"></div>

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
<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script src="//unpkg.com/vue-ckeditor2"></script>
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idnoticia; ?>" data-my_var_3="<?php echo  $this->session->user_id; ?>" src="<?php echo base_url(); ?>/assets/backend/app-vue/appcomentarioprincipal.js"></script>

<script src="<?php echo base_url(); ?>/assets/backend/plugins/styleswitcher/jQuery.style.switcher.js"></script>


</html>