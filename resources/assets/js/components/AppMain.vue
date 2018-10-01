<template>
  <v-app>
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
