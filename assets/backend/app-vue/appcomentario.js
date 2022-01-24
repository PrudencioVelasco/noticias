var this_js_script = $("script[src*=appcomentario]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
    var my_var_1 = "some_default_value";
}
var my_var_2 = this_js_script.attr("data-my_var_2");
if (typeof my_var_2 === "undefined") {
    var my_var_2 = "some_default_value";
}
var my_var_3 = this_js_script.attr("data-my_var_3");
if (typeof my_var_3 === "undefined") {
    var my_var_3 = "some_default_value";
}
Vue.config.devtools = true;
var c = new Vue({
    components: {
        VueCkeditor
    },
    el: "#appcomentario",
    data: {
        config: { 
            height: 200
          },
        url: my_var_1,
        idnoticia: my_var_2,
        idusuario: my_var_3,
        url_image: my_var_1 + "/assets/imagenesnoticias/",
        comentarios: [],
        detallenoticia: [],
        imagenes:[],
        cargando: false,
        cargando_registro: false,
        error: false,
        addRegisterComentarioAOtro: false,
        nuevoComentarioReplay: {
            idcomentario: "",
            idnoticia:  my_var_2,
            comentario: "",
            idcomentaripadre: "",
        },
        chooseComentarioReplay: {},
        formValidate: [],
        timer: null,
        currentIndex: 0
    },
    created() {
        this.todosComentarios();
        this.detalleNoticia();
        this.imagenesNoticia();
    },
    methods: {
        abrirModalRegistrar() {
            $("#addRegisterComentarioAOtro").modal({backdrop:'static',keyboard:true,show:true});
        },
        abrirModalRegistrarComentario() {
            $("#addRegisterComentario").modal({backdrop:'static',keyboard:true,show:true});
        },
        abrirModalModificar() {
            $("#modificarComentario").modal({backdrop:'static',keyboard:true,show:true});
        },
        todosComentarios() {
            axios.get(this.url + "Noticia/getItem/" + this.idnoticia)
                .then(function (response) { 
                    c.comentarios = response.data;
                });
        },
        imagenesNoticia() {
            axios.get(this.url + "Noticia/imagenesNoticia/" + this.idnoticia)
                .then(function (response) {
                    console.log(response.data.imagenes);
                    c.imagenes = response.data.imagenes;
                });
        },
        detalleNoticia() {
            axios.get(this.url + "Noticia/detalleNoticia/" + this.idnoticia)
                .then(function (response) { 
                    c.detallenoticia = response.data.detallenoticia;
                });
        },

        agregarComentario(){ 
            console.log(c.idnoticia);
            c.cargando_registro = true;
            c.cargando = true;
            c.error = false;
            var formData = c.formData(c.nuevoComentarioReplay); 
            axios.post(this.url + "Noticia/agregarComentario", formData).then(function (response) {
                if (response.data.error) {
                    c.formValidate = response.data.msg;
                    c.error = true;
                    c.cargando = false;
                    c.cargando_registro = false;
                    //v.prueba_notificacion();
                } else {
                    swal({ position: "center", type: "success", title: "Registrado!", showConfirmButton: false, timer: 1500 });

                    c.clearAll();
                    c.clearMSG();
                }
            });
        },
        modificarComentario(){
            c.cargando_registro = true;
            c.cargando = true;
            c.error = false;
            var formData = c.formData(c.chooseComentarioReplay); 
            //formData.append("idcomentario", c.chooseComentarioReplay.idcomentario);
            axios.post(this.url + "Noticia/modificarComentario", formData).then(function (response) {
                if (response.data.error) {
                    c.formValidate = response.data.msg;
                    c.error = true;
                    c.cargando = false;
                    c.cargando_registro = false;
                    //v.prueba_notificacion();
                } else {
                    swal({ position: "center", type: "success", title: "Modifcado!", showConfirmButton: false, timer: 1500 });

                    c.clearAll();
                    c.clearMSG();
                }
            });
        },
        agregarComentarioReplay(){
            console.log( c.chooseComentarioReplay);
            c.cargando_registro = true;
            c.cargando = true;
            c.error = false;
            var formData = c.formData(c.nuevoComentarioReplay); 
            formData.append("idcomentario", c.chooseComentarioReplay.idcomentario);
            axios.post(this.url + "Noticia/agregarComentarioReplay", formData).then(function (response) {
                if (response.data.error) {
                    c.formValidate = response.data.msg;
                    c.error = true;
                    c.cargando = false;
                    c.cargando_registro = false;
                    //v.prueba_notificacion();
                } else {
                    swal({ position: "center", type: "success", title: "Registrado!", showConfirmButton: false, timer: 1500 });

                    c.clearAll();
                    c.clearMSG();
                }
            });
        },
        eliminarComentario(id) {
           
            Swal.fire({
              title: "¿Eliminar Comentario?",
              text: "Realmente desea eliminar el Comentario.",
              type: "question",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Eliminar",
              cancelButtonText: "Cancelar",
            }).then((result) => {
              if (result.value) {
                axios
                  .get(this.url + "Noticia/eliminarComentario", {
                    params: {
                      idcomentario: id,
                    },
                  })
                  .then(function (response) {
                    if (response.data.error == false) {
                      //v.noResult()
                      c.clearAll();
                      c.clearMSG();
                      swal({
                        position: "center",
                        type: "success",
                        title: "Eliminado!",
                        showConfirmButton: false,
                        timer: 1500,
                      });
                    } else {
                      swal("Información", response.data.msg.msgerror, "info");
                      c.cargando = false;
                    }
                  })
                  .catch((error) => {
                    swal("Información", "No se puede eliminar el Comentario", "info");
                    c.cargando = false;
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
        selectComentarioReplay(comentario) {
            c.chooseComentarioReplay = comentario;

        },
        clearMSG() {
            setTimeout(function () {
                c.successMSG = "";
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $("#addRegisterComentarioAOtro").modal("hide"); 
            $("#addRegisterComentario").modal("hide"); 
            $("#modificarComentario").modal("hide");  
            c.cargando = false;
            c.cargando = false;
            c.error = false;
            c.cargando_registro = false;
            c.nuevoComentarioReplay = {
                idcomentario: "",
            idnoticia: c.idnoticia,
            comentario: "",
            idcomentaripadre: "",
            };
            c.formValidate = false;  
            c.todosComentarios();
        },
    },
});
