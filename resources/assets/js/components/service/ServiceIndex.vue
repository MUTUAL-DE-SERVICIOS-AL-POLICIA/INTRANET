<template>
	<v-container>
    <v-toolbar>
      <v-toolbar-title>{{ select.name }}</v-toolbar-title>
      <v-spacer></v-spacer>
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
                class="transparent mx-auto"
                slot-scope="{ hover }"
                :class="`elevation-${hover ? 15 : 2}`"
                close-delay="0"
                @click.native="openLink(service.href)"
              >
                <v-img>
                  <v-avatar
                    :size="80"
                    :tile="false"
                    @contextmenu="show($event, service.hrefManual)"
                  >
                    <img :src="service.icon.content" :alt="service.icon.name">
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
          @click="openManual(item.option)"
        >
          <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
	</v-container>
</template>

<script>
export default {
  name: "ServiceIndex",
  data() {
    return {
      showMenu: false,
      x: 0,
      y: 0,
      hrefManual: "",
      groups: [],
      services: [],
      selection: [],
      select: { id: 0, name: "APLICACIONES", shortened: "VER TODO" },
      rightClickMenu: [{ option: 0, title: "Ver Manual" }]
    };
  },
  mounted() {
    this.selection.push(this.select);
    this.getGroups();
  },
  methods: {
    mergeServices() {
      this.services = [];
      this.groups.forEach(group => {
        group.services.forEach(service => {
          this.services.push(service);
        });
      });
    },
    async getGroups() {
      try {
        let res = await axios.get("/api/v1/group");
        this.groups = res.data;
        this.groups.forEach(group => {
          this.selection.push(group);
        });
        this.mergeServices();
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
    openLink(url) {
      window.open(url);
    },
    show(e, url) {
      if (url != null) {
        this.hrefManual = url;
        e.preventDefault();
        this.showMenu = false;
        this.x = e.clientX;
        this.y = e.clientY;
        this.$nextTick(() => {
          this.showMenu = true;
        });
      }
    },
    openManual(option) {
      switch (option) {
        case 0:
          window.open(this.hrefManual);
          break;
      }
    }
  }
};
</script>
