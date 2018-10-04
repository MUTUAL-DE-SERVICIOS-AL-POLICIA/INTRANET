<template>
  <v-container >
    <v-toolbar>
        <v-toolbar-title>Grupos</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          color="tertiary"
          dark
          :to="{ name: 'iconIndex' }"
        >
          Íconos
        </v-btn>
        <v-btn
          color="tertiary"
          dark
          :to="{ name: 'serviceIndex' }"
          class="mr-4"
        >
          Servicios
        </v-btn>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <v-toolbar-title>
          <v-text-field
              v-model="search"
              append-icon="search"
              label="Buscar"
              clearable
              single-line
              hide-details
              width="20px"
            ></v-text-field>
        </v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <GroupForm :contract="{}" :bus="bus"/>
        <RemoveItem :bus="bus"/>
    </v-toolbar>
    <v-data-table
        :headers="headers"
        :items="groups"
        :search="search"
        :rows-per-page-items="[10,20,30,{text:'TODO',value:-1}]"
        disable-initial-sort
        class="elevation-1">
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-center"> {{ props.item.shortened }} </td>
            <td class="text-xs-center"> {{ props.item.name }} </td>
            <td class="justify-center layout"> 
              <v-tooltip top>
                <v-btn slot="activator" flat icon color="accent" @click="editItem(props.item)">
                  <v-icon>edit</v-icon>
                </v-btn>
                <span>Editar</span>
              </v-tooltip>
              <v-tooltip top>
                <v-btn slot="activator" flat icon color="red darken-3" @click="removeItem(props.item)">
                  <v-icon>delete</v-icon>
                </v-btn>
                <span>Eliminar</span>
              </v-tooltip>
            </td>
          </tr>
        </template>        
        <v-alert slot="no-results" :value="true" color="error">
          La búsqueda de "{{ search }}" no encontró resultados.
        </v-alert>
    </v-data-table>
  </v-container>
</template>
<script type="text/javascript">
import Vue from "vue";
import GroupForm from "./GroupForm";
import RemoveItem from "../RemoveItem";
import { admin } from "../../menu.js";
export default {
  name: "IconIndex",
  components: {
    GroupForm,
    RemoveItem
  },
  data: () => ({
    toggle_one: 0,
    bus: new Vue(),
    headers: [
      {
        text: "Sigla",
        value: "shortened",
        align: "center"
      },
      {
        text: "Grupo",
        value: "name",
        align: "center"
      },      
      {
        text: "Opciones",
        align: "center",
        sortable: false
      }
    ],
    groups: [],
    search: "",
    options: []
  }),
  computed: {    
    formTitle() {
      return this.selectedIndex === -1 ? "Nuevo grupo" : "Editar grupo";
    }    
  },
  async created() {
    this.getGroups();
    this.bus.$on("closeDialog", () => {
      this.getGroups();
    });
    // for (var i = 0; i < this.$store.getters.menuLeft.length; i++) {
    //   if (this.$store.getters.menuLeft[i].href == "contractIndex") {
    //     this.options = this.$store.getters.menuLeft[i].options;
    //   }
    // }
  },
  methods: {
    async getGroups() {
      try {
        let res = await axios.get(`/group`);
        this.groups = res.data;
        
      } catch (e) {
        console.log(e);
      }
    },
    editItem(item) {
      this.bus.$emit("openDialog", item);
    },
    async removeItem(item) {
      this.bus.$emit("openDialogRemove", `/group/${item.id}`);
    }
  }
};
</script>
