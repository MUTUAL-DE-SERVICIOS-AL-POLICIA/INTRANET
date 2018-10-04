<template>
<v-dialog persistent v-model="dialog" max-width="900px" @keydown.esc="close" scrollable>
  <v-card>
    <v-toolbar dark color="secondary">
      <v-toolbar-title class="white--text">Nuevo Servicio</v-toolbar-title>
    </v-toolbar>
    <v-card-text>
      <form ref="form">
        <v-layout wrap>
          <v-flex xs12>
            <v-text-field v-validate="'required'" :error-messages="errors.collect('Sigla')" data-vv-name="Sigla" v-model="edit.shortened" label="Sigla"></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-text-field v-model="edit.name" label="Nombre"></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-textarea v-model="edit.description" label="Descripción"></v-textarea>
          </v-flex>
          <v-flex xs12>
            <v-text-field v-validate="'required|url:require_protocol'" :error-messages="errors.collect('Enlace')" data-vv-name="Enlace" v-model="edit.href" label="Enlace" clearable></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-text-field v-validate="'url:require_protocol'" :error-messages="errors.collect('Enlace Manual')" data-vv-name="Enlace Manual" v-model="edit.hrefManual" label="Enlace Manual" clearable></v-text-field>
          </v-flex>
          <v-layout wrap>
            <v-flex xs8>
              <v-autocomplete v-validate="'required'" :error-messages="errors.collect('Ícono')" data-vv-name="Ícono" v-model="iconName" :items="iconNames" :readonly="false" label="Ícono">
                <v-slide-x-reverse-transition slot="append-outer" mode="out-in">
                  <v-icon :color="'success'" :key="iconName"></v-icon>
                </v-slide-x-reverse-transition>
              </v-autocomplete>
            </v-flex>
            <v-flex xs3 offset-xs1 v-if="iconContent">
              <v-avatar :size="80" :tile="false">
                <img :src="iconContent" :alt="iconName">
              </v-avatar>
            </v-flex>
          </v-layout>
          <v-flex xs12>
            <v-select v-validate="'required'" :error-messages="errors.collect('Grupo')" data-vv-name="Grupo" v-model="edit.group_id" :items="groups" item-text="name" item-value="id" label="Grupo"></v-select>
          </v-flex>
        </v-layout>
      </form>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="error" @click="close">
        <v-icon>close</v-icon> Cancelar
      </v-btn>
      <v-btn color="success" :disabled="this.errors.any()" @click="saveService"><v-icon>check</v-icon> Guardar</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
export default {
  name: "serviceForm",
  props: ["service", "bus"],
  data() {
    return {
      dialog: false,
      newService: true,
      edit: {
        href: "https://",
        hrefManual: "https://"
      },
      groups: [],
      iconName: null,
      iconContent: null,
      icons: [],
      iconNames: []
    };
  },
  mounted() {
    this.bus.$on("openDialog", service => {
      this.getGroups();
      this.getIcons();
      if (service) {
        this.edit = service;
        let icon = this.icons.find(obj => {
          return obj.id == this.edit.icon_id;
        });
        this.iconName = service.icon.name;
        this.iconContent = service.icon.content;
        this.newService = false;
      } else {
        this.newService = true;
      }
      this.dialog = true;
    });
  },
  methods: {
    async getGroups() {
      try {
        let res = await axios.get("/group");
        this.groups = res.data;
      } catch (e) {
        console.log(e);
      }
    },
    async getIcons() {
      try {
        let res = await axios.get("/icon");
        this.icons = res.data;
        this.icons.forEach(icon => {
          this.iconNames.push(icon.name);
        });
      } catch (e) {
        console.log(e);
      }
    },
    resetVariables() {
      this.edit = {
        href: "https://",
        hrefManual: "https://"
      };
      this.iconName = null;
      this.iconContent = null;
    },
    close() {
      this.resetVariables();
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
    },
    async saveService() {
      try {
        let valid = await this.$validator.validateAll();
        let res;
        if (valid) {
          if (this.newService) {
            res = await axios.post(`/service`, this.edit, {
              headers: {
                Authorization: `${this.$store.getters.token.type} ${this.$store.getters.token.value}`
              }
            });
            this.toastr.success("Insertado correctamente");
          } else {
            res = await axios.patch(
              `/service/${this.edit.id}`,
              this.edit
            );
            this.toastr.success("Actualizado correctamente");
          }
          this.close();
        }
      } catch (e) {
        console.log(e);
      }
    }
  },
  watch: {
    iconName(value) {
      if (value) {
        let image = this.icons.find(obj => {
          return obj.name == value;
        });
        if (image) {
          this.iconContent = image.content;
          this.edit.icon_id = image.id;
        }
      }
    }
  }
};
</script>
