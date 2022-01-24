<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">REGISTRAR NOTICIA</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="text-danger" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> Titulo
                                    </label>
                                    <input type="text" v-model="nuevaNoticia.titulo" class="form-control" :class="{'is-invalid': formValidate.titulo}" name="po">
                                </div>
                                <div class="text-danger" v-html="formValidate.titulo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> Redactar
                            </label>
                            <vue-ckeditor v-model="nuevaNoticia.contenido" :config="config" />
                        </div>
                    </div>
                    <div class="text-danger" v-html="formValidate.contenido"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>Imagenes</label>
                            <input type="file" @change="onChangeFileUploadAdd" class="form-control" accept="image/png, image/jpeg" id="fileadd" ref="fileadd" name="po" multiple>
                            <strong v-if=" filesSend.length > 0">Archivo(s) seleccionado(s):</strong>
                            <ul>
                                <li v-for="file in filesSend" :key="file.name" style="list-style-type: none;">
                                    <i class='fa fa-trash' v-on:click="removeElement(file.name)" style="color: red;"></i>
                                    {{ file.name }}
                                </li>
                            </ul>
                            <br>
                            <small>Subir documento si es necesario.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="center">
                        <div v-if="cargando">
                            <img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error" align="left">
                            <label class="text-danger">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>

                        <button v-if="!cargando_registro" class="btn btn-primary waves-effect waves-black" @click="agregarNoticia">
                            <i class='fa fa-floppy-o'></i> Registrar
                        </button>

                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_registro"><i class="fa fa-spin fa-spinner"></i> Registrando noticia...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">MODIFICAR NOTICIA</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="text-danger" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> Titulo
                                    </label>
                                    <input type="text" v-model="chooseNoticia.titulo" class="form-control" :class="{'is-invalid': formValidate.titulo}" name="po">
                                </div>
                                <div class="text-danger" v-html="formValidate.titulo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> Redactar
                            </label>
                            <vue-ckeditor v-model="chooseNoticia.contenido" :config="config" />
                        </div>
                    </div>
                    <div class="text-danger" v-html="formValidate.contenido"></div>
                    <br>
                    <div class="row"> 
                    <div   v-for="imagen in imagenes">
                        
                            <div class="col-md-3 ">
                                <div class="card" style="width: 10rem;">
                                    <img class="card-img-top" v-bind:src="url_image + imagen.nombreimagen" width="100" height="100" >
                                    <div class="card-body text-left" align="left" >
                                        <button class="btn btn-danger" @click="eliminarImagen(imagen.idimagen); selectImagen(imagen)"  >Eliminar</button>
                                    </div>
                                </div>
                            </div> 
                    </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>Imagenes</label>
                            <input type="file" @change="onChangeFileUploadAdd" class="form-control" accept="image/png, image/jpeg" id="fileadd" ref="fileadd" name="po" multiple>
                            <strong v-if=" filesSend.length > 0">Archivo(s) seleccionado(s):</strong>
                            <ul>
                                <li v-for="file in filesSend" :key="file.name" style="list-style-type: none;">
                                    <i class='fa fa-trash' v-on:click="removeElement(file.name)" style="color: red;"></i>
                                    {{ file.name }}
                                </li>
                            </ul>
                            <br>
                            <small>Subir documento si es necesario.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="center">
                        <div v-if="cargando">
                            <img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error" align="left">
                            <label class="text-danger">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cerrar</button>

                        <button v-if="!cargando_registro" class="btn btn-primary waves-effect waves-black" @click="modificarNoticia">
                            <i class='fa fa-floppy-o'></i> Modificar
                        </button>

                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_registro"><i class="fa fa-spin fa-spinner"></i> Modificando noticia...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>