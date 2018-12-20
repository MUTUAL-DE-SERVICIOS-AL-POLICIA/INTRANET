<template>
  <v-dialog persistent v-model="dialog" :max-width="maxWidth" :fullscreen="fullScreen" @keydown.esc="close">
    <v-tooltip slot="activator" top>
      <v-icon large slot="activator" dark color="primary">add_circle</v-icon>
      <span>Nuevo comunicado</span>
    </v-tooltip>
    <v-card>
      <v-toolbar dark color="secondary">
        <v-toolbar-title class="white--text">{{ formTitle }} </v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-container grid-list-md layout>
          <v-layout wrap>
            <v-flex xs12 sm12 md12>
              <v-form ref="form">
                <v-select
                  v-model="selectedItem.notice_type_id"                  
                  :items="notice_types"
                  item-text="name"
                  item-value="id"
                  label="Tipo"
                  v-validate="'required'"
                  name="Tipo"
                  :error-messages="errors.collect('Tipo')"
                ></v-select>
                <v-text-field
                  v-model="selectedItem.origin"
                  label="Oficina de origen"
                  v-validate="'required'"
                  name="Oficina de origen"
                  :error-messages="errors.collect('Oficina de origen')"
                ></v-text-field>
                <v-text-field
                  v-model="selectedItem.title"
                  label="Titulo"
                  v-validate="'required'"
                  name="Titulo"
                  :error-messages="errors.collect('Titulo')"
                ></v-text-field>
                <div align="center">
                  <v-radio-group v-model="modes" :mandatory="false" color="error" row>
                    <v-radio label="Crear documento" value="1" @change="setMode(1)"></v-radio>
                    <v-radio label="Subir documento" value="2" @change="setMode(2)"></v-radio>
                  </v-radio-group>
                </div>
                <div v-if="modes==1">
                  <Vueditor ref="editor" style="min-height:400px;"></Vueditor>
                </div>
                <v-layout wrap>
                  <v-flex xs3 v-if="modes==2">
                    <upload-btn title="" :fileChangedCallback="fileChanged">
                      <template slot="icon">
                        <v-icon dark>file_upload</v-icon> Subir PDF
                      </template>
                    </upload-btn>
                  </v-flex>
                  <v-flex xs9>
                    <p class="mt-2"> {{ fileText }} </p>
                  </v-flex>
                </v-layout>
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
let config = {
      toolbar: [
        'removeFormat', 'undo', '|', 'elements', 'fontName', 'fontSize', 'foreColor', 'backColor', 'divider',
        'bold', 'italic', 'underline', 'strikeThrough', 'link', 'unLink', 'divider', 'subscript', 'superscript',
        'divider', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull', '|', 'indent', 'outdent',
        'insertOrderedList', 'insertUnorderedList', '|', 'table', '|', 'sourceCode', 'fullscreen'
      ],
      fontName: [
        {val: 'arial black'}, 
        {val: 'times new roman'}, 
        {val: 'Courier New'}
      ],
      fontSize: ['12px', '14px', '16px', '18px', '0.8rem', '1.0rem', '1.2rem', '1.5rem', '2.0rem'],
      uploadUrl: '#',
      id: '',
      classList: []
    };
import Vue from 'vue'
import Vuex from 'vuex'
import UploadButton from 'vuetify-upload-button';
import Vueditor from 'vueditor'
Vue.use(Vuex)
Vue.use(Vueditor, config);
export default {
  name: "NoticeForm",
  props: ["item", "bus"],
  components: {
    'upload-btn': UploadButton
  },
  data() {
    return {
      maxWidth: '900px',
      fullScreen: false, 
      valid: true,      
      dialog: false,
      selectedIndex: -1,
      notice_types: [],
      selectedItem: {
        
      },
      files: null,
      fileText: null,
      modes: 1,
    };
  },
  computed: {
    formTitle() {
      return this.selectedIndex === -1
        ? "Nuevo":"Editar";
    },    
  },
  methods: {
    setMode(mode) {
      if (mode == 1) {
        this.files = null;
        this.fileText = null;
      } else {
        this.content = null;
      }
    },
    fileChanged (file) {
      this.files = file;
      this.fileText = file.name;
    } ,
    close() {
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
      this.selectedIndex = -1;
      // this.$refs.editor.setContent("");
      this.selectedItem = {};
      this.files = null;
      this.fileText = null;
      this.modes = 1;
    },
    async getNoticeTypes() {
      try {
        let res = await axios.get('/notice_type');
        this.notice_types = res.data;
      } catch (e) {
        console.log(e);
      }
    },
    async save() {
      try {
        let valid = await this.$validator.validateAll();
        if (valid) {
          if (this.modes == 1) {
            this.selectedItem.content = this.$refs.editor.getContent()            
          }
          if (this.selectedIndex != -1) {
            let res = await axios.patch(`/notice/${this.selectedItem.id}`, this.selectedItem);            
            this.close();
            this.toastr.success("Editado correctamente");
          } else {
            let formData = new FormData();
            formData.append('notice_type_id', this.selectedItem.notice_type_id);
            formData.append('origin', this.selectedItem.origin);
            formData.append('title', this.selectedItem.title);
            formData.append('content', this.selectedItem.content);
            formData.append('file', this.files);
            let res = await axios.post("/notice", formData);
            this.close();
            this.toastr.success("Registrado correctamente");
          }
        }
      } catch (e) {
        console.log(e);
      }
    },
    
  },
  mounted() {
    this.modes = "1";
    this.getNoticeTypes();
    this.bus.$on("openDialog", item => {
      this.selectedItem = item;      
      this.dialog = true;
      this.selectedIndex = item;
      if (item.url_document) {
        this.modes = "2";
        this.files = item.url_document;
        this.fileText = item.url_document;
      } else {
        this.modes = "1";
        this.$refs.editor.setContent(item.content);
      }
      
    });
    this.$watch(
      () => {
        return this.$refs.editor.fullscreen
      },
      (val) => {
        if (val == true) {
          this.maxWidth = '';
          this.fullScreen = true;
        } else {
          this.maxWidth = '900px';
          this.fullScreen = false;
        }        
      }
    )
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