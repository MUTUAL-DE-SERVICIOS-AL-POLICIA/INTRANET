<template>
	<v-container>
    <v-toolbar>
      <v-toolbar-title>{{ select.name }}</v-toolbar-title>
      <v-spacer></v-spacer>
      <RemoveItem :bus="bus"/>
      <ServiceForm :bus="bus"/>
      <v-btn
        color="tertiary"
        dark
        :to="{ name: 'changePassword' }"
        class="mr-5"
        v-if="!$store.getters.currentUser"
      >
        Cambiar contraseña
      </v-btn>
      <v-btn
        color="tertiary"
        dark
        :to="{ name: 'iconIndex' }"
        v-if="$store.getters.currentUser"
      >
        Íconos
      </v-btn>
      <v-btn
        color="tertiary"
        dark
        :to="{ name: 'groupIndex' }"
        class="mr-5"
        v-if="$store.getters.currentUser"
      >
        Grupos
      </v-btn>
      <v-flex xs2>
        <v-select
          v-model="select"
          :items="selection"
          item-text="shortened"
          item-value="id"
          return-object
          single-line
          @change="filterGroup"
        ></v-select>
      </v-flex>
    </v-toolbar>
		<v-container fluid fill-height>
			<v-layout row wrap align-center justify-center text-xs-center>
				<v-flex v-for="service in services" :key="service.id" xs12 sm5 md3 lg2 xl2 class="ml-4 mr-4 mb-5">
          <v-tooltip top>
            <v-hover slot="activator" close-delay="100">
              <v-card
                class="blurred"
                slot-scope="{ hover }"
                :class="`elevation-${hover ? 15 : 2}`"
                @click.native="openLink(service)"
                @contextmenu="show($event, service)"
              >
                <v-tooltip bottom open-delay="4000" :disabled="service.description == null || service.description == ''">
                  <v-img class="pt-3" slot="activator">
                    <v-avatar
                      :size="160"
                      :tile="false"
                    >
                      <img :src="service.icon.content" :alt="service.icon.name" v-if="service.icon.content">
                      <v-icon
                        v-else
                        large
                      >add</v-icon>
                    </v-avatar>
                  </v-img>
                  <span class="title font-weight-light">{{ service.description }}</span>
                </v-tooltip>
                <v-card-text class="title font-weight-regular text-truncate">{{ service.shortened }}</v-card-text>
              </v-card>
            </v-hover>
            <span class="title font-weight-regular">{{ service.name }}</span>
          </v-tooltip>
				</v-flex>
			</v-layout>
		</v-container>
    <v-menu
      v-model="showMenu"
      :position-x="x"
      :position-y="y"
      absolute
      offset-y
    >
      <v-list>
        <v-list-tile
          v-for="(item, index) in rightClickMenu"
          :key="index"
          @click="selectOption(item.option)"
        >
          <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
	</v-container>
</template>

<script>
import Vue from "vue";
import ServiceForm from "./ServiceForm";
import RemoveItem from "../RemoveItem";

export default {
  name: "ServiceIndex",
  components: {
    ServiceForm,
    RemoveItem
  },
  data() {
    return {
      bus: new Vue(),
      showMenu: false,
      x: 0,
      y: 0,
      selected: {},
      groups: [],
      services: [],
      selection: [],
      select: { id: 0, name: "APLICACIONES", shortened: "VER TODO" },
      rightClickMenu: []
    };
  },
  mounted() {
    this.selection.push(this.select);
    this.getGroups();
    this.bus.$on("closeDialog", () => {
      this.getGroups();
    });
  },
  methods: {
    addNewService() {
      if (this.$store.getters.currentUser) {
        this.services.push({
          id: 0,
          name: "AÑADIR SERVICIO",
          shortened: "NUEVO",
          icon: {
            content: null
          }
        });
      }
    },
    mergeServices() {
      this.services = [];
      this.addNewService();
      this.groups.forEach(group => {
        group.services.forEach(service => {
          this.services.push(service);
        });
      });
    },
    async getGroups() {
      try {
        let res = await axios.get("/group");
        this.groups = res.data;
        this.groups.forEach(group => {
          this.selection.push(group);
        });
        this.mergeServices();
        this.filterGroup();
      } catch (e) {
        console.log(e);
      }
    },
    filterGroup() {
      if (this.select.id == 0) {
        this.mergeServices();
      } else {
        let group = this.groups.find(obj => {
          return obj.id == this.select.id;
        });
        this.services = group.services;
      }
    },
    openLink(service) {
      if (service.id != 0) {
        window.open(service.href);
      } else {
        this.bus.$emit("openDialog");
      }
    },
    show(e, service) {
      if (service.id != 0) {
        this.selected = service;

        this.rightClickMenu = [
          {
            option: 0,
            title: "Abrir"
          }
        ]

        if (this.selected.href_manual) {
          this.rightClickMenu.push({
            option: 1,
            title: "Ver Manual"
          });
        }

        if (this.selected.href_test) {
          this.rightClickMenu.push({
            option: 2,
            title: "Versión de Prueba"
          });
        }

        if (this.$store.getters.currentUser) {
          this.rightClickMenu.push({
            option: 3,
            title: "Editar"
          });
          this.rightClickMenu.push({
            option: 4,
            title: "Eliminar"
          });
        }

        e.preventDefault();
        this.showMenu = false;
        this.x = e.clientX;
        this.y = e.clientY;
        this.$nextTick(() => {
          this.showMenu = true;
        });
      }
    },
    selectOption(option) {
      switch (option) {
        case 0:
          this.openLink(this.selected)
          break;
        case 1:
          window.open(this.selected.href_manual);
          break;
        case 2:
          window.open(this.selected.href_test);
          break;
        case 3:
          this.bus.$emit("openDialog", this.selected);
          break;
        case 4:
          this.bus.$emit("openDialogRemove", `/service/${this.selected.id}`);
          break;
      }
    },
    newItem() {
      this.bus.$emit("openDialog");
    }
  }
};
</script>

<style>
.blurred {
  background-color: rgba(255, 255, 255, 0.25) !important;
  cursor: pointer;
  border-radius: 30px;
}
</style>
