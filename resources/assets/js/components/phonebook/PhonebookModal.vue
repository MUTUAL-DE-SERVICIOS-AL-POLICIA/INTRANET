<template>
  <v-dialog scrollable persistent v-model="dialog" max-width="900px" @keydown.esc="dialog = false">
      <v-card>
        <v-toolbar dark color="primary">
          <v-toolbar-title>NÚMEROS DE TELÉFONOS INTERNOS</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <v-layout row>
            <v-flex xs9>

            </v-flex>
            <v-flex xs3>
              <v-text-field
                v-model="search"
                append-icon="search"
                label="Buscar"
                clearable
                single-line
                hide-details
                width="20px"
              ></v-text-field>
            </v-flex>
          </v-layout>
          
          <v-data-table
            :headers="headers"
            :items="phones"
            :search="search"
            :rows-per-page-items="[10,20,30,{text:'TODO',value:-1}]"
            disable-initial-sort
            class="elevation-1">
            <template slot="items" slot-scope="props">
              <tr>
                <td class="text-xs-left"> {{ props.item.position_group.name }} </td>
                <td class="text-xs-left"> {{ props.item.name }} </td>
                <td class="text-xs-center"> {{ props.item.phone_number }} </td>
              </tr>
            </template>        
            <v-alert slot="no-results" :value="true" color="error">
              La búsqueda de "{{ search }}" no encontró resultados.
            </v-alert>
          </v-data-table>
        </v-card-text>
        <v-card-actions>
        <v-spacer></v-spacer>
          <v-btn color="error" @click="printItem()"><v-icon>print</v-icon> Imprimir</v-btn>
          <v-btn color="success" @click="dialog=false"><v-icon>check</v-icon> Aceptar</v-btn>
        </v-card-actions>
        <v-divider></v-divider>
      </v-card>
  </v-dialog>
</template>
<script>
export default {
  name: "Phonebook",
  props: ["item", "bus"],
  data() {
    return {            
      dialog: false,
      phones: [],
      search: "",
      headers: [
        {
          text: "Dirección",
          value: "position_group.name",
          align: "center"
        }, {
          text: "Ubicación",
          value: "name",
          align: "center"
        }, {
          text: "No. Interno",
          value: "phone_number",
          align: "center"
        },
      ],
    };
  },
  created() {

  },
  computed: {
      
  },
  methods: {
    async getPhones() {
      try{
        let res = await axios.get(`/phonebook`);
        this.phones = res.data;
      } catch(e) {
        console.log(e);
      }
    },
    async printItem() {
      try {        
        let res = await axios({
          method: "GET",
          url: `/phonebook/print`,
          responseType: "arraybuffer"
        });
        let blob = new Blob([res.data], {
          type: "application/pdf"
        });
        printJS(window.URL.createObjectURL(blob));
      } catch (e) {
        console.log(e);
      }
    },
  },
  mounted() {
    this.bus.$on("openDialogPhonebook", item => {
      this.dialog = true;
      this.getPhones();
    });
  }
};
</script>