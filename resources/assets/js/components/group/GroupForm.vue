<template>
  <v-dialog persistent v-model="dialog" max-width="900px" @keydown.esc="close">
    <v-tooltip slot="activator" top>
      <v-icon large slot="activator" dark color="primary">add_circle</v-icon>
      <span>Nuevo Icono</span>
    </v-tooltip>
    <v-card>
      <v-toolbar dark color="secondary">
        <v-toolbar-title class="white--text">{{ formTitle }}</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-container grid-list-md layout>
          <v-layout wrap>
            <v-flex xs12 sm12 md12>
              <v-form ref="form">
                <v-text-field
                  v-model="selectedItem.shortened"
                  label="Sigla"
                  v-validate="'required'"
                  name="Sigla"
                  :error-messages="errors.collect('Sigla')"
                ></v-text-field>
                <v-text-field
                  v-model="selectedItem.name"
                  label="Nombre de grupo"
                  v-validate="'required'"
                  name="Nombre"
                  :error-messages="errors.collect('Nombre')"
                ></v-text-field>
              </v-form>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card-text>  
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" @click.native="close"><v-icon>close</v-icon> Cancelar</v-btn>
        <v-btn color="success" :disabled="!valid" @click="save()"><v-icon>check</v-icon> Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "GroupForm",
  props: ["item", "bus"],
  data() {
    return {      
      valid: true,      
      dialog: false,
      selectedIndex: -1,      
      selectedItem: {
        shortened: "",
        name: ""
      }      
    };
  },
  created() {
    // for (var i = 0; i < this.$store.getters.menuLeft.length; i++) {
    //   if (this.$store.getters.menuLeft[i].href == "contractIndex") {
    //     this.options = this.$store.getters.menuLeft[i].options;
    //   }
    // }
    // if (this.$store.getters.currentUser.roles[0].name == "juridica") {
    //   this.juridica = 1;
    // }
  },
  computed: {
    formTitle() {
      return this.selectedIndex === -1
        ? "Nuevo":"Editar";
    }    
  },
  methods: {
    async initialize() {
      try {        
      } catch (e) {
        console.log(e);
      }
    },
    close() {
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
      this.selectedItem = {
        shortened: "",
        name: ""
      };
    },
    async save() {
      try {
        await this.$validator.validateAll();
        if (this.selectedIndex != -1) {
          let res = await axios.patch("/api/v1/group/" + this.selectedItem.id, this.selectedItem);
          this.close();
          this.toastr.success("Editado correctamente");
        } else {
          let res = await axios.post("/api/v1/group", this.selectedItem);
          this.close();
          this.toastr.success("Registrado correctamente");
        }
      } catch (e) {
        console.log(e);
      }
    }
  },
  mounted() {
    this.bus.$on("openDialog", item => {
      this.selectedItem = item;
      this.dialog = true;
      this.selectedIndex = item;      
    });
    this.initialize();
  }
};
</script>