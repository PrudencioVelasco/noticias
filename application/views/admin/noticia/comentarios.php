<div class="row">
    <div class="col-lg-12">
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
                        <button class="btn btn-primary" @click="abrirModalRegistrarComentario()">Comentar</button>
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
                                            <a v-if="idusuario == row.idusuario" @click="eliminarComentario(row.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                            <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row);" v-if="idusuario == row.idusuario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>
                                            <a @click="abrirModalRegistrar(); selectComentarioReplay(row);" title="Comentar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-mail-forward"></i> Comentar</a>
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
                                                                    <a v-if="idusuario == row2.idusuario" @click="eliminarComentario(row2.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                                    <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row2);" v-if="idusuario == row2.idusuario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>
                                                                    <a @click="abrirModalRegistrar(); selectComentarioReplay(row2);" title="Comentar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-mail-forward"></i> Comentar</a>

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
                                                                                        <a v-if="idusuario == row3.idusuario" @click="eliminarComentario(row3.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                                                        <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row3);" v-if="idusuario == row3.idusuario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>
                                                                                        <a @click="abrirModalRegistrar(); selectComentarioReplay(row3);" title="Comentar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-mail-forward"></i> Comentar</a>

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
                                                                                                            <a v-if="idusuario == row4.idusuario" @click="eliminarComentario(row4.idcomentario);" title="Eliminar comentario" href="javascript:void(0)" class="link m-r-10"><i class="fa fa-trash"></i> Eliminar</a>
                                                                                                            <a title="Modificar comentario" @click="abrirModalModificar(); selectComentarioReplay(row4);" v-if="idusuario == row4.idusuario" href="javascript:void(0)" class="link m-r-10"><i class="fa  fa-pencil"></i> Modificar</a>

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
                    <div v-if="comentarios != ''" class="text-left">
                        <button class="btn btn-primary" @click="abrirModalRegistrarComentario()">Comentar</button>
                    </div>
                </div>
            </div>
            <?php include 'modal_comentario.php'; ?>
        </div>
    </div>