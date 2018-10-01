<template>
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex v-for="group in groups" :key="group.id" xs4>
        <v-card dark :color="group.color">
          <v-card-text></v-card-text>
        </v-card>
      </v-flex>
		</v-layout>
	</v-container>
</template>

<script>
export default {
  name: "ServiceIndex",
  data() {
    return {
      groups: []
    };
	},
	mounted() {
		this.getGroups();
	},
  methods: {
    async getGroups() {
      try {
        let res = await axios.get("/api/v1/group");
				this.groups = res.data;
				console.log(this.groups)
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>

