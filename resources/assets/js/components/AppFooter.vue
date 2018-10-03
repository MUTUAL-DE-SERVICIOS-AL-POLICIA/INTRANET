<template>
  <v-footer fixed app>
    <v-btn flat small v-if="!$store.getters.currentUser">
      <router-link tag="span" :to="{ name: 'loginForm' }" class="font-weight-thin caption">Ingresar</router-link>
    </v-btn>
    <v-btn flat small v-else @click.native="logout">
      <span class="font-weight-thin caption">
        Cerrar sesión
      </span>
    </v-btn>
    <v-spacer></v-spacer>
    <span class="font-weight-thin caption">MUSERPOL <span class="copyleft">&copy;</span> - 2018</span>
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