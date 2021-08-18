<template>
  <div class="form">
    <form onsubmit="return false">
      <label for="name">Property Name:</label>
      <input name="fname" required v-model="name">
      <br>
      <label for="margin">Margin:</label>
      <input name="margin" required v-model="margin">
      <br>
      <button v-on:click="returnToHomepage" type="button">Return</button>
      <button v-on:click="submitForm(name, margin)" type="button">Submit</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "Form",
  data() {
    return {
      name: "",
      margin: ""
    };
  },
  methods: {
    returnToHomepage() {
      this.$store.dispatch("toggleCreation", false);
    },
    submitForm(name, margin) {
      let isNumeric = value => {
        return /^-?\d+$/.test(value);
      };

      let error = {};
      error =
        name.length == 0
          ? { hasError: true, message: "Must supply a name" }
          : margin.length == 0
          ? { hasError: true, message: "Must supply a margin" }
          : isNumeric(margin) == false
          ? { hasError: true, message: "Margin must be a number" }
          : { hasError: false };

      if (error.hasError) {
        alert(error.message);
      } else {
        this.$emit("submitForm", name, margin);
      }
    }
  }
};
</script>

<style scoped>
div.form {
  display: block;
  text-align: center;
}
form {
  display: inline-block;
  margin-left: auto;
  margin-right: auto;
  text-align: left;
}
</style>
