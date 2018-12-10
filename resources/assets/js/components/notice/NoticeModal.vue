<template>
  <v-dialog persistent v-model="dialog" max-width="900px" @keydown.esc="dialog = false">    
    <v-card>
      <v-toolbar dark color="primary">        
        <v-spacer></v-spacer>
        <v-btn icon dark @click="dialog = false">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-flex xs12 sm12 md12>
        <v-expansion-panel v-model="panel" expand>
          <v-expansion-panel-content
            v-for="(notice,i) in notices"
            :key="i">
            <div slot="header" style="text-transform: uppercase; font-weight: bold;"> {{ notice.notice_type.name + '  ' + notice.correlative + '/' + notice.year }} </div>
            <v-card>
              <v-card-text><span v-html="notice.content"></span></v-card-text>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-flex>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  name: "NoticeModal",
  props: ["item", "bus"],
  data() {
    return {            
      dialog: false,
      panel: [true],
      notices: []         
    };
  },
  created() {
  },
  computed: {
      
  },
  methods: {    
  },
  mounted() {
    this.bus.$on("openDialogModal", item => {
      this.notices = item;
      this.dialog = true;
    });
  }
};
</script>