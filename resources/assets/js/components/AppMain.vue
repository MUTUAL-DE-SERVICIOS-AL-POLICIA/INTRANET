<template>
  <v-app>
    <AppHeader></AppHeader>
    <v-content>
      <v-parallax src="/img/fondo.jpg" fluid>
        <v-layout
          align-center
          column>
          <v-slide-x-transition>
            <router-view></router-view>
          </v-slide-x-transition>
        </v-layout>
      </v-parallax>
    </v-content>
    <AppFooter></AppFooter>
  </v-app>
</template>

<script>
import AppHeader from './AppHeader'
import AppFooter from './AppFooter'

export default {
  name: "AppMain",
  components: {
    AppHeader,
    AppFooter
  }
};
</script>

<style>
.copyleft {
  display:inline-block;
  transform: rotate(180deg);
}
</style>
