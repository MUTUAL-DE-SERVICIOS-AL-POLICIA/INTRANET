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
        :to="{ name: 'iconIndex' }"
        v-if="$store.getters.currentUser"
      >
        Íconos
      </v-btn>
      <v-btn
        color="tertiary"
        dark
        :to="{ name: 'groupIndex' }"
        class="mr-4"
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
		<v-container grid-list-md text-xs-center>
			<v-layout row wrap>
				<v-flex v-for="service in services" :key="service.id" xs4 sm3 md2 lg1>
          <v-tooltip top>
            <v-hover slot="activator">
              <v-card
                class="blurred"
                slot-scope="{ hover }"
                :class="`elevation-${hover ? 15 : 2}`"
                close-delay="0"
                @click.native="openLink(service)"
              >
                <v-img class="pt-3">
                  <v-avatar
                    :size="80"
                    :tile="false"
                    @contextmenu="show($event, service)"
                  >
                    <img :src="service.icon.content" :alt="service.icon.name" v-if="service.icon.content">
                    <v-icon
                      v-else
                      large
                    >add</v-icon>
                  </v-avatar>
                </v-img>
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
      rightClickMenu: [{ option: 0, title: "Ver Manual" }]
    };
  },
  mounted() {
    if (this.$store.getters.currentUser) {
      this.rightClickMenu.push({
        option: 1,
        title: "Editar"
      });
      this.rightClickMenu.push({
        option: 2,
        title: "Eliminar"
      });
    }
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
          window.open(this.selected.href_manual);
          break;
        case 1:
          this.bus.$emit("openDialog", this.selected);
          break;
        case 2:
          this.bus.$emit("openDialogRemove", `/service/${this.selected.id}`);
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
}
</style>
