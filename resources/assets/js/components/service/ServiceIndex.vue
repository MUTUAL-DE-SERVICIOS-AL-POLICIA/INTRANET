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
	</v-container>
</template>

<script>
export default {
  name: "ServiceIndex",
  data() {
    return {
      groups: [],
      services: [],
      selection: [],
      select: { id: 0, name: "APLICACIONES", shortened: "VER TODO" }
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
    }
  }
};
</script>
