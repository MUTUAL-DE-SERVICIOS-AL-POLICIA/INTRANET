<template>
  <v-app>
    <v-toolbar color="normal" fixed app>      
      <v-img src="/img/logo.png" contain max-width="150"></v-img>
      <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
      <v-spacer></v-spacer>      
      <v-toolbar-title>INTRANET - Escritorio Virtual</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
      <v-img src="/img/escudo_bolivia.png" contain max-width="80"></v-img>
    </v-toolbar>
    <v-content>
      <v-slide-x-transition>
        <router-view></router-view>
      </v-slide-x-transition>
    </v-content>
    <v-footer fixed app>
      <v-spacer></v-spacer>
      <span class="font-weight-thin caption">MUSERPOL <span class="copyleft">&copy;</span> - 2018</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: "app-header"
};
</script>

<style>
.copyleft {
  display:inline-block;
  transform: rotate(180deg);
}
</style>
