<div class="modal fade" id="addRegisterComentario" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Hacer un comentario</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> Redactar
                            </label>
                            <vue-ckeditor v-model="nuevoComentarioReplay.comentario" :config="config" />
                        </div>
                    </div>
                    <div class="text-danger" v-html="formValidate.comentario"></div>

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

                        <button v-if="!cargando_registro" class="btn btn-primary waves-effect waves-black" @click="agregarComentario">
                            <i class='fa fa-floppy-o'></i> Comentar
                        </button>

                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_registro"><i class="fa fa-spin fa-spinner"></i> Comentando...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRegisterComentarioAOtro" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Hacer un comentario</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> Redactar
                            </label>
                            <vue-ckeditor v-model="nuevoComentarioReplay.comentario" :config="config" />
                        </div>
                    </div>
                    <div class="text-danger" v-html="formValidate.comentario"></div>

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

                        <button v-if="!cargando_registro" class="btn btn-primary waves-effect waves-black" @click="agregarComentarioReplay">
                            <i class='fa fa-floppy-o'></i> Comentar
                        </button>

                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_registro"><i class="fa fa-spin fa-spinner"></i> Comentando...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modificarComentario" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Modificar comentario</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> Redactar
                            </label>
                            <vue-ckeditor v-model="chooseComentarioReplay.comentario" :config="config" />
                        </div>
                    </div>
                    <div class="text-danger" v-html="formValidate.comentario"></div>

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

                        <button v-if="!cargando_registro" class="btn btn-primary waves-effect waves-black" @click="modificarComentario">
                            <i class='fa fa-floppy-o'></i> Modificar
                        </button>

                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_registro"><i class="fa fa-spin fa-spinner"></i> Modificando...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>