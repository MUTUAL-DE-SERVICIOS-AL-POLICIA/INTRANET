<template>
  <v-footer fixed app>
    <v-btn flat small v-if="!$store.getters.currentUser" :to="{ name: 'loginForm' }">
      <span class="font-weight-thin caption">Ingresar</span>
    </v-btn>
    <v-btn flat small v-else @click.native="logout">
      <span class="font-weight-thin caption">
        Cerrar sesión
      </span>
    </v-btn>
    <v-spacer></v-spacer>
    <span class="font-weight-thin caption pr-3">MUSERPOL <span class="copyleft">&copy;</span> - 2018</span>
  </v-footer>
</template>

<script>
export default {
  name: "AppFooter",
  methods: {
    logout() {
      this.$store.commit("logout");
      this.$router.push({
        name: "serviceIndex"
      });
      location.reload();
    }
  }
};
</script>