<template>
  <div class="home">
    <h1>XPerience.immo</h1>

    <div v-if="isCreating">
      <form-component @submitForm="submitForm"></form-component>
    </div>
    <div v-else>
      <p v-if="isLoading">Chargement en course...</p>
      <div v-else>
        <form>
          <button v-on:click="openForm">New Programme</button>

          <input v-model="filter" type="text" required>
          <button v-on:click="getProgrammesByFilter(filter)" type="submit">Submit</button>
          <p v-show="serverMessage.length > 0">{{serverMessage}}</p>
        </form>
        <table style="width:100%">
          <tr>
            <th>Name</th>
            <th>Agency</th>
            <th>Margin</th>
          </tr>
          <tr v-for="(programme, index) of programmes" :key="index">
            <td>{{programme.name}}</td>
            <td>
              <span v-if="programme.agency">{{programme.agency.name}}</span>
            </td>
            <td>{{programme.margin}}</td>
          </tr>
        </table>
        Average - {{average}}
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "@/services";
import form from "@/components/Form.vue";
export default {
  name: "Home",
  computed: {
    isCreating: function() {
      return this.$store.getters.getIsCreating;
    }
  },
  data() {
    return {
      programmes: [],
      isLoading: true,
      hasError: false,
      average: null,
      filter: null,
      serverMessage: "",
      name: null,
      margin: null
    };
  },
  created() {
    this.getProgrammes();
  },
  methods: {
    async getProgrammesByFilter(minimum) {
      try {
        const response = await apiClient.getProgrammes(minimum);
        response.data.message
          ? this.displayMessage(response.data.message)
          : null;
        this.programmes = response.data.properties;
        this.calculateAverage();
      } catch (error) {
        console.log(error);
      }
    },

    displayMessage(message) {
      this.serverMessage = message;
      setTimeout(() => {
        this.serverMessage = "";
      }, 3000);
    },

    calculateAverage() {
      let value = 0;
      for (let programme of this.programmes) {
        value += programme.margin;
      }
      this.average = (value / this.programmes.length).toFixed(2);
    },

    async getProgrammes() {
      try {
        const response = await apiClient.getProgrammes();
        this.programmes = response.data.properties;
        this.calculateAverage();
        this.isLoading = false;
      } catch (error) {
        this.hasError = true;
        console.log(error);
      }
    },

    async submitForm(name, margin) {
      try {
        const response = await apiClient.createProgramme(name, margin);
        this.programmes.push(response.data);
        this.$store.dispatch("toggleCreation", false);
      } catch (error) {
        console.log(error);
        this.$store.dispatch("toggleError", true);
      }
    },

    openForm() {
      this.$store.dispatch("toggleCreation", true);
    }
  },
  components: {
    "form-component": form
  }
};
</script>

