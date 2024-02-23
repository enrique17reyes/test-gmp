<template>
    <div style="text-align: center; margin-left: 5%; margin-right: 5%;">
        <div class="row">
            <div class="col-6 mt-3" style="text-align: left;">
                <a href="/">
                    <button class="btn btn-warning">
                        Volver a registrar productos
                    </button>
                </a>

            </div>
            <div class="col-6 mt-3" style="text-align: right;">

                    <button @click="exportExcel()" class="btn btn-success">
                        Exportar
                    </button>


            </div>


        </div>


        <h1>Productos</h1>

        <div style="align-items: center;">
            <v-server-table
                style="height: 100%;width: 100%;"
                class="text-center"
                url="/products-list"
                :columns="columns"
                :options="options"
                ref="tabla_kits"
            >

            </v-server-table>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {

                products: [],
                //
                UrlServer: "",
                columns: ["clave", "categoria", "producto", "precio"],
                options: {
                    sortIcon: {
                        base: "fa",
                        is: "fa-sort",
                        up: "fa-sort-up",
                        down: "fa-sort-down",
                    },
                    headings: {
                        clave: "Clave",
                        categoria: "Categoría",
                        producto: "Producto",
                        precio: "Precio",
                    },
                    sortable: [],
                    texts: {
                        count:
                            "MOSTRANDO DE {from} A {to} DE {count} REGISTROS|SE ENCONTRARÓN {count} REGISTROS | SE ENCONTRÓ UN REGISTRO",
                        filter: "BUSCAR:",
                        filterPlaceholder: "BUSCAR...",
                        limit: "REGISTROS:",
                        recordsDisplay: "REGISTROS",
                        page: "PÁGINAS:",
                        noResults: "NO HAY REGISTROS",
                        filterBy: "BUSCAR...",
                        loading: "CARGANDO...",
                        defaultOption: "SELECCIONAR {column}",
                    },
                    filterable: [],
                    filterByColumn: true,
                    resizableColumns: false,
                    perPage: 7,
                    perPageValues: [5,7, 10, 15, 20],

                    requestAdapter: function (data) {
                        return {
                            limit: data.limit,
                            page: data.page,
                            query: data.query,
                            ascending: data.ascending,
                            byColumn: data.byColumn,
                            orderBy: data.orderBy,
                            sort: data.orderBy ? data.orderBy : "clave",
                            direction: data.ascending ? "asc" : "desc",
                        };
                    },
                    responseAdapter: function (resp) {
                        var data = this.getResponseData(resp);
                        try {
                            return {
                            data: data.data,
                            count: data.count,
                            };
                        } catch (error) {
                            toastr.error(error);
                        }
                    },
                },

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


            exportExcel(){
                window.open('/export', '_blank');
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
