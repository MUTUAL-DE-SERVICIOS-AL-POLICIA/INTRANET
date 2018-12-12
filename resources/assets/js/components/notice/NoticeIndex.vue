<template>
  <v-container >
    <v-toolbar>
        <v-toolbar-title>Comunicados</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          color="tertiary"
          dark
          :to="{ name: 'changePassword' }"
          class="mr-5"
          v-if="!$store.getters.currentUser"
        >
          Cambiar contraseña
        </v-btn>
        <span v-if="$store.getters.currentUser">
        <v-btn
          color="tertiary"
          dark
          :to="{ name: 'iconIndex' }"
          v-if="$store.getters.currentUser.roles[0].name == 'admin'"
        >
          Íconos
        </v-btn>
        <v-btn
          color="tertiary"
          dark
          :to="{ name: 'groupIndex' }"        
          v-if="$store.getters.currentUser.roles[0].name == 'admin'"
        >
          Grupos
        </v-btn>
        <v-btn
          color="tertiary"
          dark
          :to="{ name: 'userIndex' }"        
          v-if="$store.getters.currentUser.roles[0].name == 'admin'"
        >
          Usuarios
        </v-btn>
        <v-btn
          color="tertiary"
          dark
          class="mr-5"
          :to="{ name: 'noticeIndex' }"
          v-if="$store.getters.currentUser.roles[0].name == 'admin'||$store.getters.currentUser.roles[0].name == 'secretaria'"
        >
          Comunicados
        </v-btn>
        </span>
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
        <NoticeForm :contract="{}" :bus="bus"/>
        <RemoveItem :bus="bus"/>
    </v-toolbar>
    <v-data-table
        :headers="headers"
        :items="notices"
        :search="search"
        :rows-per-page-items="[10,20,30,{text:'TODO',value:-1}]"
        disable-initial-sort
        class="elevation-1">
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-center"> {{ props.item.notice_type.name }} </td>
            <td class="text-xs-center"> {{ props.item.title }} </td>
            <td class="text-xs-center"> {{ props.item.origin }} </td>
            <td class="text-xs-center"> {{ props.item.correlative }} </td>
            <td class="text-xs-center"> {{ props.item.year }} </td>
            <td class="text-xs-center"> 
              <v-switch
                v-model="props.item.active"
                color="info"
                @click.native="switchActive(props.item)"
              ></v-switch>
            </td>
            <td class="justify-center layout">
              <v-tooltip top>
                <v-btn slot="activator" flat icon color="accent" @click="printItem(props.item)">
                  <v-icon>print</v-icon>
                </v-btn>
                <span>Imprimir</span>
              </v-tooltip>
              <v-tooltip top>
                <v-btn slot="activator" flat icon color="accent" @click="editItem(props.item, 'edit')">
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
import NoticeForm from "./NoticeForm";
import RemoveItem from "../RemoveItem";
import { admin } from "../../menu.js";
export default {
  name: "noticeIndex",
  components: {
    NoticeForm,
    RemoveItem
  },
  data: () => ({
    toggle_one: 0,
    bus: new Vue(),
    headers: [
      {
        text: "Typo",
        value: "notice_type.name",
        align: "center"
      }, {
        text: "titulo",
        value: "title",
        align: "center"
      }, {
        text: "Origen",
        value: "origin",
        align: "center"
      }, {
        text: "correlativo",
        value: "correlative",
        align: "center"
      },{
        text: "Gestión",
        value: "year",
        align: "center"
      }, {
        text: "Activo",
        value: "active",
        align: "center"
      }, {
        text: "Opciones",
        value: "",
        align: "center",
        sortable: false
      }
    ],
    notices: [],
    search: "",
    options: []
  }),
  computed: {    
    formTitle() {
      return this.selectedIndex === -1 ? "Nueva noticia" : "Editar noticia";
    }    
  },
  async created() {
    this.getNotices();
    this.bus.$on("closeDialog", () => {
      this.getNotices(this.active);
    });
    // console.log(this.$store.getters.currentUser.roles[0].name);
  },
  methods: {
    async getNotices() {
      try {
        let res = await axios.get(`/notice`);
        this.notices = res.data;
        
      } catch (e) {
        console.log(e);
      }
    },
    editItem(item, mode) {
      this.bus.$emit("openDialog", $.extend({}, item, { mode: mode }));
    },
    async switchActive(notice) {
      try {
        let res = await axios.patch(`/notice/${notice.id}`, {
          active: notice.active
        });
        this.getNotices();
      } catch (e) {
        console.log(e);
      }
    },
    async printItem(item) {
      try {
        let res = await axios({
          method: "GET",
          url: `/notice/print/${item.id}`,
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
    async removeItem(item) {
      this.bus.$emit("openDialogRemove", `/notice/${item.id}`);
    }
  }
};
</script>
