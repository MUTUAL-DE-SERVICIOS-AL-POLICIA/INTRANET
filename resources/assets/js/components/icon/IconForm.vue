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
                  v-model="selectedItem.name"
                  label="Nombre del icono"
                  v-validate="'required'"
                  name="Nombre"
                  :error-messages="errors.collect('Nombre')"
                ></v-text-field>
                <div align="center">
                <div class="upload-btn-wrapper">
                  <button class="btn"><v-icon>file_upload</v-icon> Cargar Icono</button>
                      <input
                      type="file"
                      accept="image/*"
                      v-on:change="onSelectIcon"
                      class="upload"
                    >
                </div>
                <v-spacer></v-spacer>
                <img id="img" height="60">
                </div>
                <v-textarea
                  v-model="selectedItem.content"
                  style="display:none"
                ></v-textarea>                
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
  name: "IconForm",
  props: ["item", "bus"],
  data() {
    return {      
      valid: true,      
      dialog: false,
      selectedIndex: -1,      
      selectedItem: {
        name: "",
        content: ""
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
        // console.log(e);
      }
    },
    close() {
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
      this.selectedItem = {
        name: "",
        content: ""
      };
    },
    async save() {
      try {
        await this.$validator.validateAll();
        if (this.selectedIndex != -1) {
          let res = await axios.patch("/icon/" + this.selectedItem.id, this.selectedItem);
          this.close();
          this.toastr.success("Editado correctamente");
        } else {
          let res = await axios.post("/icon", this.selectedItem);
          this.close();
          this.toastr.success("Registrado correctamente");
        }
      } catch (e) {
        console.log(e);
      }
    },
   
    async onSelectIcon(v) {
      if (v) {
        var input = v.target;
        var reader = new FileReader();
        reader.onload = function(){
          var dataURL = reader.result;
          document.getElementById("img").src = reader.result;
          this.selectedItem.content = dataURL;                    
        }.bind(this);
        reader.readAsDataURL(input.files[0]);        
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
<style type="text/css">
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>