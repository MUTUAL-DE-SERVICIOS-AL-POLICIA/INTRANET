<template>
  <v-dialog scrollable persistent v-model="dialog" max-width="900px" @keydown.esc="dialog = false">
      <v-card>
        <v-toolbar dark color="primary">
          <v-spacer></v-spacer>
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-divider></v-divider>
        <v-card-text style="height: 610px;">
          <v-expansion-panel expand v-model="panel">
            <v-expansion-panel-content 
              v-for="(notice,i) in notices"
              :key="i" @click.native="changeItem(i)">
              <div slot="header" style="text-transform: uppercase;text-align:center; font-weight: bold;"> {{ notice.notice_type.name + '  ' + notice.correlative + '/' + notice.year }} </div>
              <v-card style="overflow-y: auto;" :height="alt">
                <v-card-text ><span v-html="notice.content"></span></v-card-text>
              </v-card>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-card-text>
        <v-divider></v-divider>
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
      alt: 565,
      notices: []       
    };
  },
  created() {

  },
  computed: {
      
  },
  methods: {
    changeItem(i) {
      this.panel = [false];
      this.panel[i] = true;
    }
  },
  mounted() {
    this.bus.$on("openDialogModal", item => {
      this.notices = item;
      this.dialog = true;
      this.alt = this.alt - (50 * item.length);
      setInterval(() => {
        this.changeItem(item.length-1);
      }, 5000);      
    });
  }
};
</script>