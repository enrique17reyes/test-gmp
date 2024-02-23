<template>
    <div style="text-align: center;">
        <h1>Productos</h1>
        <div style="margin-bottom: 5%; margin-top: 5%; margin-left: 5%; margin-right: 5%;">

            <div class="row">

                <div style="text-align: left;" class="col-md-3">
                    <label  class="form-label">Clave</label>
                    <input maxlength="4" type="text" v-model="articulo.art_clave" class="form-control"  placeholder="Ingrese la clave">
                </div>
                <div style="text-align: left;" class="col-md-3">
                    <label  class="form-label">Categoría</label>
                    <input type="text" v-model="articulo.art_categoria" class="form-control"  placeholder="Ingrese la categoria">
                </div>
                <div style="text-align: left;" class="col-md-3">
                    <label  class="form-label">Producto</label>
                    <input type="text" v-model="articulo.art_producto" class="form-control"  placeholder="Ingrese el producto">
                </div>
                <div style="text-align: left;" class="col-md-3">
                    <label  class="form-label">Precio</label>
                    <input type="number" v-model="articulo.art_precio" class="form-control"  placeholder="Ingrese el precio">
                </div>

            </div>

            <div class="mt-3 mb-3">
                <button :disabled="articulo.art_clave == null || articulo.art_categoria == null || articulo.art_producto == null || articulo.art_precio == null || articulo.art_clave == '' || articulo.art_categoria == '' || articulo.art_producto == '' || articulo.art_precio == ''" type="button" @click="agregar_articulo_lista(articulo)" class="btn btn-success">
                    Agregar
                </button>
            </div>

            <div class="mb-4">
                <div class="container">
                    <table class="bordered-table">
                        <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Categoría</th>
                                <th>Producto</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in productos_temp" :key="index">
                            <td>{{ item.art_clave }}</td>
                            <td>{{ item.art_categoria }}</td>
                            <td>{{ item.art_producto }}</td>
                            <td>{{ item.art_precio }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3 mb-3">
                <button :disabled="productos_temp.length < 1" type="button" @click="guardar()" class="btn btn-primary">
                    Guardar
                </button>
            </div>

            <div class="mt-3 mb-3">
                <a href="/tabla-export">
                    <button class="btn btn-warning">
                        Ver tabla de exportación
                    </button>
                 </a>
            </div>

        </div>


        <!-- <div style="align-items: center;">
            <v-server-table
                style="height: 100%;width: 100%;"
                class="text-center"
                url="/products-list"
                :columns="columns"
                :options="options"
                ref="tabla_kits"
            >

            </v-server-table>
        </div> -->
    </div>
</template>

<script>
    export default {

        data() {
            return {

                products: [],
                //
                productos_temp: [],

                articulo:{
                    art_clave: null,
                    art_categoria: null,
                    art_producto: null,
                    art_precio: null,
                },

            }
        },

        mounted() {



        },

        methods: {


            async agregar_articulo_lista(articulo){
                // console.log(this.select);

                this.select = false;


                let data = {
                    clave: this.articulo.art_clave,
                };

                let peticion = await axios.post("/products/dup",data);

                if (peticion.data.status) {

                    this.select = true;

                    Swal.fire({
                        icon: "error",
                        html: `<p>Ya existe un registro en la base de datos con la clave proporcionada</p>`,
                        confirmButtonText: "ACEPTAR",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        allowEnterKey: false,
                    }).then((respuesta) => {
                        return;
                    });


                }


                this.productos_temp.forEach(element => {
                    if(element.art_clave == articulo.art_clave){
                        this.select = true;

                        Swal.fire({
                            icon: "error",
                            html: `<p>Ya existe un registro con la clave proporcionada</p>`,
                            confirmButtonText: "ACEPTAR",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            allowEnterKey: false,
                        }).then((respuesta) => {

                        });

                    }
                });

                if(this.select == false){
                    this.productos_temp.push(articulo);
                    this.select = false;

                    this.articulo ={
                        art_clave: null,
                        art_categoria: null,
                        art_producto: null,
                        art_precio: null,
                    };

                }
            },

            guardar: async function () {
                try {

                    let respuesta = await Swal.fire({
                        icon: "question",
                        title: "CONFIRMAR",
                        html: "<p> ¿DESEA GUARDAR LOS DATOS? </p>",
                        confirmButtonText: "ACEPTAR",
                        showCancelButton: true,
                        cancelButtonText: "CANCELAR",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        allowEnterKey: false,
                        reverseButtons: true,
                    });

                    if (respuesta.value) {
                        let data = {
                            articulos: this.productos_temp,
                        };

                        let peticion = await axios.post("/products/store",data);

                        if (peticion.data.status) {
                        Swal.close();

                        Swal.fire({
                            icon: "success",
                            html: `<p>SE GUARDARON LOS CAMBIOS</p>`,
                            confirmButtonText: "ACEPTAR",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            allowEnterKey: false,
                        }).then((respuesta) => {
                            this.productos_temp = [];
                        });


                        } else {
                            Swal.fire({
                                icon: "error",
                                html: `<p> OCURRIO UN ERROR AL MODIFICAR</p>`,
                                confirmButtonText: "ACEPTAR",
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                allowEnterKey: false,
                            }).then((respuesta) => {
                                $("#marcasi").modal({
                                backdrop: "static",
                                keyboard: false,
                                });
                            });
                        }
                    } else {

                    }

                } catch (error) {
                    console.log(error);
                    Swal.fire({
                        icon: "error",
                        html: "<p> HA OCURRIDO UN ERROR </p>",
                        confirmButtonText: "ACEPTAR",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        allowEnterKey: false,
                    }).then((respuesta) => {

                    });
                }
            },

            revisarDup: async function () {
                try {

                    let data = {
                        clave: this.articulo.art_clave,
                    };

                    let peticion = await axios.post("/products/dup",data);

                    if (peticion.data.status) {
                        Swal.close();

                        Swal.fire({
                            icon: "success",
                            html: `<p>SE GUARDARON LOS CAMBIOS</p>`,
                            confirmButtonText: "ACEPTAR",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            allowEnterKey: false,
                        }).then((respuesta) => {
                            $("#marcasi").modal("hide");
                        });


                    } else {
                        Swal.fire({
                            icon: "error",
                            html: `<p>La clave del registro ya se encuentra en la base de datos</p>`,
                            confirmButtonText: "ACEPTAR",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            allowEnterKey: false,
                        }).then((respuesta) => {
                            $("#marcasi").modal({
                            backdrop: "static",
                            keyboard: false,
                            });
                        });
                    }


                } catch (error) {
                    console.log(error);
                    Swal.fire({
                        icon: "error",
                        html: "<p> HA OCURRIDO UN ERROR </p>",
                        confirmButtonText: "ACEPTAR",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        allowEnterKey: false,
                    }).then((respuesta) => {
                        $("#marcasi").modal({ backdrop: "static", keyboard: false });
                    });
                }
            },



        }

    }
</script>

<style>

.container {
  display: flex;
  justify-content: center;
  align-items: center;

}

.bordered-table {
  border-collapse: collapse;
  width: 100%;
  border: 2px solid #000;
}

.bordered-table th,
.bordered-table td {
  border: 1px solid #000;
  padding: 8px;
}

</style>
