<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="appnoticia">
                    <h4 class="card-title">Administrador de Noticias</h4>
                    <button class="btn btn-primary" @click="abrirModal">Registrar</button><br><br>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                            <div v-if="buscandoregistro">
                                <label><strong> Buscando...</strong> <i class="fa fa-spin fa-spinner fa-2x" style="color:royalblue"></i> </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <input placeholder="Buscar" :autofocus="'autofocus'" type="search" class="form-control btn-round" v-model="search.text" @keyup="buscarNoticias" name="search"><br /><br>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table color-table info-table">
                            <thead>
                                <tr> 
                                    <th>Titulo</th>
                                    <th>Autor</th>
                                    <th>F. Publicado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index)  in noticias"> 
                                    <td>{{row.titulo}}</td>
                                    <td>{{row.nombre}} {{row.apepaterno}} {{row.apematerno}}</td>
                                    <td>{{row.fecharegistro}}</td>
                                    <td align="right">

                                        <div class="btn-group" role="group">
                                            <button id="btnGroupVerticalDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                                <a class="dropdown-item" @click="eliminarNoticia(row.idnoticia)" href="#">Eliminar</a>
                                                <a class="dropdown-item" @click="selectNoticia(row); abrirEditarModal()" href="#">Modificar</a>
                                                <a class="dropdown-item" v-bind:href="'comentarios/'+ row.idnoticia">Detalle</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <tr v-if="emptyResult">
                                    <td colspan="5" class="text-center h4">No encontrado</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="center">
                                        <pagination :current_page="currentPage" :row_count_page="rowCountPage" @page-update="pageUpdate" :total_users="totalNoticias" :page_range="pageRange">
                                        </pagination>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php include 'modal.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>