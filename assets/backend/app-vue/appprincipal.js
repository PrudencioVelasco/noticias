var this_js_script = $("script[src*=appprincipal]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
    var my_var_1 = "some_default_value";
}
Vue.config.devtools = true;
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        url_image: my_var_1 + "/assets/imagenesnoticias/",
        search: {
            text: ""
          },
        noticias: [], 
        sinresultado:false,
        chooseEscuela: {},
        formValidate: [],
        successMSG: '',
    },
    created() {
        this.showAll();
    },
    methods: {
        showAll() { 
            axios.get(this.url + "Principal/noticiasPrincipal/")
            .then(function (response) {
                console.log(response);
                v.noticias = response.data;
            });
        },
        buscarNoticias(){
            var formData = v.formData();
            v.noticias = [];
            v.sinresultado = false;
            formData.append("text",this.$refs.textbuscar.value);
            if (this.$refs.textbuscar.value != "") {
            axios.post(this.url + "Principal/buscarNoticias", formData).then(function (response) {
              if (response.data == '') {
               // v.noResult()
               // v.buscandoalumno = false;
               console.log("asdas");
               v.sinresultado = true;
              } else {
                v.noticias =response.data; 
              }
            })
        }else{
            v.showAll();
        }
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },

        selectEscuela(escuela) {
            v.chooseEscuela = escuela;
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
    }
})
