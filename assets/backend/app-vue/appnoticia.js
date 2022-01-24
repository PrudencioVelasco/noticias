var this_js_script = $("script[src*=appnoticia]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
    var my_var_1 = "some_default_value";
}
Vue.config.devtools = true;
Vue.use(VueCkeditor);
var v = new Vue({
  components: {
    VueCkeditor
  },
    el: "#appnoticia",
    data: {
        config: {
            //toolbar: [
            //  ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
            //],
            height: 200
          },
        url: my_var_1,
        addModal: false,
        editModal: false,
        buscandoregistro: false,
        cargando: false,
        cargando_registro: false,
        error: false,
        noticias: [],
        imagenes: [],
        url_image: my_var_1 + "/assets/imagenesnoticias/",
        search: { text: "" },
        emptyResult: false,
        nuevaNoticia: {
            idnoticia: "",
            titulo: "",
            contenido: "",
            idusuario: "",
            fecharegistro: "",
        },
        chooseNoticia: {},
        chooseImagen: {},
        formValidate: [],
        filesSend: [],
        file: "",
        successMSG: "",
        currentPage: 0,
        rowCountPage: 10,
        totalNoticias: 0,
        pageRange: 2,
        directives: { columnSortable },
    },
    created() {
        this.todasNoticias();
    },
    methods: {
        abrirModal() {
            $("#addRegister").modal({backdrop:'static',keyboard:true,show:true});
        },
        abrirEditarModal() {
            $("#editRegister").modal({backdrop:'static',keyboard:true,show:true});
        },
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.noticias.sort(sortFn);
        },
        onChangeFileUploadAdd(e) {
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {
              this.filesSend.push(selectedFiles[i]);
            }
          },
          onChangeFileUploadEdit(e) {
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {
              this.filesSend.push(selectedFiles[i]);
            }
          },
          removeElement: function (index) {
            this.filesSend.splice(index, 1);
            if (this.filesSend.length == 0) {
              this.$refs.fileadd.value = "";
            }
          },
          imagenesNoticia(id) {
            axios.get(this.url + "Noticia/imagenesNoticia/" + id)
                .then(function (response) {
                    console.log(response);
                    v.imagenes = response.data.imagenes;
                });
        },
        todasNoticias() {
            axios.get(this.url + "Noticia/todasNoticias").then(function (response) {
                if (response.data.noticias == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.noticias);
                }
            })
        },
        buscarNoticias() {
            var formData = v.formData(v.search);
            v.cargando_registro = true;
            axios.post(this.url + "Noticia/buscarNoticias", formData).then(function (response) {
                if (response.data.noticias == null) {
                    v.noResult()
                    v.cargando_registro = false;
                } else {
                    v.getData(response.data.noticias);
                    v.cargando_registro = false;
                }
            })
        },
        agregarNoticia() {
            v.cargando_registro = true;
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.nuevaNoticia);
            for (var i = 0; i < this.filesSend.length; i++) {
                let file = this.filesSend[i];
                formData.append("files[" + i + "]", file);
            }
            axios.post(this.url + "Noticia/agregarNoticia", formData, {
                headers: {
                    "Content-Type": "multipart/form-dara"
                }
            }).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                    v.cargando_registro = false;
                    //v.prueba_notificacion();
                } else {
                    swal({ position: "center", type: "success", title: "Registrado!", showConfirmButton: false, timer: 1500 });

                    v.clearAll();
                    v.clearMSG();
                }
            });
        },
        modificarNoticia() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.chooseNoticia);
            for (var i = 0; i < this.filesSend.length; i++) {
                let file = this.filesSend[i];
                formData.append("files[" + i + "]", file);
            }
            axios
                .post(this.url + "Noticia/modificarNoticia", formData, {
                    headers: {
                        "Content-Type": "multipart/form-dara"
                    }
                })
                .then(function (response) {
                    if (response.data.error) {
                        v.formValidate = response.data.msg;
                        v.cargando = false;
                        v.error = true;
                    } else {
                        //v.successMSG = response.data.success;
                        v.clearAll();
                        v.clearMSG();
                        swal({
                            position: "center",
                            type: "success",
                            title: "Modificado!",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
        },
        eliminarNoticia(id) {
            v.error = false;
            v.cargando = true;
            Swal.fire({
                title: "¿Eliminar Noticia?",
                text: "Realmente desea eliminar la Noticia.",
                type: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    axios
                        .get(this.url + "Noticia/eliminarNoticia", {
                            params: {
                                idnoticia: id,
                            },
                        })
                        .then(function (response) {
                            if (response.data.error == false) {
                                //v.noResult()
                                v.clearAll();
                                v.clearMSG();
                                swal({
                                    position: "center",
                                    type: "success",
                                    title: "Eliminado!",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            } else {
                                swal("Información", response.data.msg.msgerror, "info");
                                v.cargando = false;
                            }
                        })
                        .catch((error) => {
                            swal("Información", "No se puede eliminar el Alumno", "info");
                            v.cargando = false;
                        });
                }
            });
        },

        eliminarImagen(id) {
           console.log(id);
            Swal.fire({
              title: "¿Eliminar Imagen?",
              text: "Realmente desea eliminar la Imagen.",
              type: "question",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Eliminar",
              cancelButtonText: "Cancelar",
            }).then((result) => {
              if (result.value) {
                axios
                  .get(this.url + "Noticia/eliminarImagen", {
                    params: {
                        idimagen: id,
                    },
                  })
                  .then(function (response) {
                    if (response.data.error == false) { 
                      v.imagenesNoticia(v.chooseNoticia.idnoticia);
                      swal({
                        position: "center",
                        type: "success",
                        title: "Eliminado!",
                        showConfirmButton: false,
                        timer: 1500,
                      });
                    } else {
                      swal("Información", response.data.msg.msgerror, "info");
                     // c.cargando = false;
                    }
                  });
              }
            });
          },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        getData(noticias) {
            v.emptyResult = false; // become false if has a record
            v.totalNoticias = noticias.length //get total of user
            v.noticias = noticias.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.noticias.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },

        selectNoticia(noticia) {
            v.chooseNoticia = noticia;
            console.log(noticia.idnoticia);
            v.imagenesNoticia(noticia.idnoticia);

        },
        selectImagen(imagen) {
            v.chooseImagen = imagen;

        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = "";
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $("#editRegister").modal("hide");
            $("#addRegister").modal("hide");
            this.$refs.fileadd.value = "";
            v.filesSend = [];
            v.cargando = false;
            v.error = false;
            v.cargando_registro = false;
            v.nuevaNoticia = {
                idnoticia: "",
                titulo: "",
                contenido: "",
                idusuario: "",
                fecharegistro: "",
                smserror: "",
            };
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false; 
            v.refresh();
        },
        noResult() {
            v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
            v.noticias = null;
            v.totalNoticias = 0; //remove current page if is empty
        },

        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh();
        },
        refresh() {
            v.search.text ? v.buscarNoticias() : v.todasNoticias(); //for preventing
        },
    },
});
