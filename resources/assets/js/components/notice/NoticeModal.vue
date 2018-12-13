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
              <div slot="header" style="text-transform: uppercase;text-align:left; font-weight: bold;"> {{ notice.notice_type.name + '  MUSERPOL/DGE/' + notice.correlative + '/' + notice.year }} </div>
              <v-card style="overflow-y: auto;" :height="alt">
                <hr>
                <div style="border-bottom: 1px solid #e2e0e0;margin: 0 15px 0 15px;">
                  <v-layout row wrap>                  
                    <v-flex xs2>
                      <v-img src="/img/logo.png" width="150" style="margin: 0 0 0 15px;"></v-img>
                    </v-flex>
                    <v-flex xs8>
                      <p style="text-align: center;font-size: 16pt;font-weight: bold;margin-top:20px;">MUTUAL DE SERVICIOS AL POLICÍA</p>
                    </v-flex>
                    <v-flex xs2>
                      <v-img src="/img/escudo_bolivia.png" width="80" style="text-align: right;"></v-img>
                    </v-flex>
                  </v-layout>
                </div>
                <p style="text-transform: uppercase;text-align:center; font-weight: bold;margin-top:15px;"> 
                  <span style="font-size:14pt;">{{ notice.notice_type.name }} </span> <br>
                  <span> MUSERPOL/DGE/{{ notice.correlative + '/' + notice.year }}</span>
                </p>
                <v-card-text ><span v-html="notice.content"></span></v-card-text>
                <div style="border-top: 1px solid #e2e0e0;margin: 0 15px 0 15px;text-align:center;">
                  <span>Av. 6 de Agosto No. 2354 * Tel&eacute;fonos: 2441169 - 2440365 * Fax: (591-2)2440185</span><br>
                  <span>www.muserpol.gob.bo</span>
                </div>
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
    });
  }
};
</script>