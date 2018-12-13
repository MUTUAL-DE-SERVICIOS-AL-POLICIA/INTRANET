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
                <div>
                  <Vueditor ref="editor" style="min-height:400px;"></Vueditor>
                </div>
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
import Vueditor from 'vueditor'
Vue.use(Vuex)
Vue.use(Vueditor, config);
export default {
  name: "NoticeForm",
  props: ["item", "bus"],
  data() {
    return {
      maxWidth: '900px',
      fullScreen: false, 
      valid: true,      
      dialog: false,
      selectedIndex: -1,
      notice_types: [],
      selectedItem: {
        notice_type_id: null,
        origin: null,
        title: null,
        content: null
      }      
    };
  },
  computed: {
    formTitle() {
      return this.selectedIndex === -1
        ? "Nuevo":"Editar";
    },    
  },
  methods: {   
    close() {
      this.dialog = false;
      this.$validator.reset();
      this.bus.$emit("closeDialog");
      this.selectedIndex = -1;
      this.$refs.editor.setContent("");
      this.selectedItem = {
        title: "",
        content: ""
      };
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
          this.selectedItem.content = this.$refs.editor.getContent()
          if (this.selectedIndex != -1) {
            let res = await axios.patch(`/notice/${this.selectedItem.id}`, this.selectedItem);
            this.close();
            this.toastr.success("Editado correctamente");
          } else {
            let res = await axios.post("/notice", this.selectedItem);
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
    this.getNoticeTypes();
    this.bus.$on("openDialog", item => {
      this.selectedItem = item;
      this.$refs.editor.setContent(item.content);
      this.dialog = true;
      this.selectedIndex = item;
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