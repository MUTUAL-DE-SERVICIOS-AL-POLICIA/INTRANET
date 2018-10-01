<template>
  <v-app>
    <v-toolbar color="indigo" dark fixed app>      
      <v-toolbar-title>MUSERPOL</v-toolbar-title>
      <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
      <v-spacer></v-spacer>      
      <v-toolbar-title>MUSERPOL</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
      <v-toolbar-title>MUSERPOL</v-toolbar-title>
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
