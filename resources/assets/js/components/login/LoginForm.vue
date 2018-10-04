<template>
	<v-container fluid fill-height id="background-page">
    <v-layout row align-center justify-center>
      <v-flex d-flex xs12 sm6 md4>
        <v-card class="pa-5 ma-5">
          <v-form>
            <v-text-field
              v-validate="'required|min:5|max:255'"
              @keyup.enter="focusPassword()"
              v-model="auth.username"
              prepend-icon="person"
              label="Usuario"
              name="usuario"
              :error-messages="errors.collect('usuario')"
              autocomplete="on"
              autofocus
              required
            ></v-text-field>
            <v-text-field
              v-validate="'required|min:5|max:255'"
              @keyup.enter="authenticate(auth)"
              v-model="auth.password"
              prepend-icon="lock"
              label="Contraseña"
              type="password"
              autocomplete="on"
              ref="password"
              name="contraseña"
              :error-messages="errors.collect('contraseña')"
              required
            ></v-text-field>
            <v-card-actions>
              <v-btn
                @click="authenticate(auth)"
                primary
                large
                block
                color="success"
              > Ingresar </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: "loginForm",
  data() {
    return {
      auth: {
        username: "",
        password: ""
      },
      error: null
    };
  },
  methods: {
    focusPassword() {
      this.$refs.password.focus();
    },
    async authenticate(auth) {
      try {
        if (await this.$validator.validateAll()) {
          let res = await axios.post("/auth", auth);
          this.$store.commit("login", res.data);
          this.$router.push({
            name: "serviceIndex"
          });
        }
      } catch (e) {
        auth.password = "";
        this.focusPassword();
      }
    }
  }
};
</script>
