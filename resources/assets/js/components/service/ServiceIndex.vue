<template>
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex v-for="group in groups" :key="group.id" xs4>
        <v-card dark :color="group.color">
					<v-card-title primary-title>
						<span class="headline font-weight-bold">{{ group.name }}</span>
					</v-card-title>
					<v-container grid-list-md>
						<v-layout row wrap>
							<v-flex v-for="service in group.services" :key="service.id" xs4>
								<v-hover>
									<v-card
										slot-scope="{ hover }"
										:class="`elevation-${hover ? 20 : 2}`"
										class="transparent"
										:close-delay="0"
									>
										<a :href="service.href" style="text-decoration: none;">
											<v-avatar	size="128">
												<img :src="`data:image/${service.icon.format};base64,${service.icon.content}`" :alt="service.icon.name">
											</v-avatar>
											<v-card-text>
												<span class="headline font-weight-light white--text">
													{{ service.shortened }}
												</span>
											</v-card-text>
										</a>
									</v-card>
								</v-hover>
							</v-flex>
						</v-layout>
					</v-container>
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
