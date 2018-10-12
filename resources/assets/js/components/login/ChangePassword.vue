<template>
  <v-container fluid fill-height id="background-page" @keydown.esc="$router.push({ name: 'serviceIndex' })">
    <v-layout row align-center justify-center>
      <v-flex d-flex xs12 sm6 md4>
        <v-card class="pa-5 ma-5">
          <v-card-title primary-title>
            <div>
              <div class="headline">Cambiar contraseña</div>
            </div>
          </v-card-title>
          <v-form>
            <v-text-field
              v-validate="'required|min:4|max:255'"
              @keyup.enter="focusInput('old_password')"
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
              v-validate="'required|min:4|max:255'"
              @keyup.enter="focusInput('new_first_password')"
              v-model="auth.old_password"
              prepend-icon="lock"
              label="Contraseña Actual"
              type="password"
              autocomplete="on"
              ref="old_password"
              name="Contraseña Actual"
              :error-messages="errors.collect('Contraseña Actual')"
              required
            ></v-text-field>
            <v-text-field
              v-validate="'required|min:5|max:255'"
              @keyup.enter="focusInput('new_second_password')"
              v-model="passwordConfirm.first"
              prepend-icon="lock"
              label="Contraseña Nueva"
              type="password"
              autocomplete="on"
              ref="new_first_password"
              name="Contraseña Nueva"
              :error-messages="errors.collect('Contraseña Nueva')"
              required
            ></v-text-field>
            <v-text-field
              v-validate="'required|min:5|max:255'"
              @keyup.enter="changePassword()"
              v-model="passwordConfirm.second"
              prepend-icon="lock"
              label="Repita la Contraseña"
              type="password"
              autocomplete="on"
              ref="new_second_password"
              name="Repita la Contraseña"
              :error-messages="errors.collect('Repita la Contraseña')"
              required
            ></v-text-field>
            <v-card-actions>
              <v-btn
                :to="{ name: 'serviceIndex' }"
                primary
                large
                block
                color="error"
              > Volver </v-btn>
              <v-btn
                @click="changePassword()"
                primary
                large
                block
                color="success"
              > Cambiar Contraseña </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: "changePassword",
  data() {
    return {
      auth: {
        username: "",
        old_password: "",
        new_password: ""
      },
      passwordConfirm: {
        first: "",
        second: ""
      },
      error: null
    };
  },
  methods: {
    cleanForm() {
      this.auth.old_password = "";
      this.auth.new_password = "";
      this.passwordConfirm = {
        first: "",
        second: ""
      };
    },
    focusInput(input) {
      this.$refs[input].focus();
    },
    async changePassword() {
      try {
        if (await this.$validator.validateAll()) {
          if (this.passwordConfirm.first == this.passwordConfirm.second) {
            this.auth.new_password = this.passwordConfirm.first;
            let res = await axios.patch("/user", this.auth);
            this.toastr.success(res.data.message);
            this.$router.push({
              name: "serviceIndex"
            });
          } else {
            this.passwordConfirm = {
              first: "",
              second: ""
            };
            this.focusInput("new_first_password");
            this.toastr.error("Las contraseñas no coinciden");
          }
        }
      } catch (e) {
        this.cleanForm();
        this.focusInput("old_password");
        console.log(e);
      }
    }
  }
};
</script>
