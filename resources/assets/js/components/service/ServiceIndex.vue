<template>
  <div>
    Servicios
  </div>
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
    this.getGroups()
  },
  methods: {
    async getGroups() {
      try {
        let res = axios.get("/api/v1/group");
        this.groups = res.data;
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>

