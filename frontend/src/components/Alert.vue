<template>
  <div v-if="booked === 'sold'" class="alert alert-danger alert-dismissible fade show" role="alert">
    The Seat already sold out for this date!
    <button type="button" class="btn-close" @click="dismissAlert" aria-label="Close"></button>
  </div>
  <div v-else-if="booked === 'reserved'" class="alert alert-secondary alert-dismissible fade show" role="alert">
    At the moment this seat reserved for this date!
    <button type="button" class="btn-close" @click="dismissAlert" aria-label="Close"></button>
  </div>
  <div v-else-if="booked === 'timeout'" class="alert alert-warning alert-dismissible fade show" role="alert">
    Sorry your reservation expired try again!
    <button type="button" class="btn-close" @click="dismissAlert" aria-label="Close"></button>
  </div>
  <div v-else-if="booked === 'booked'" class="alert alert-success alert-dismissible fade show" role="alert">
      You have successfully reserved your seat.
    <button type="button" class="btn-close" @click="dismissAlert" aria-label="Close"></button>
  </div>
</template>

<script>
export default {
  name: "Alert",
  props:['booked'],
  methods: {

    dismissAlert(){
      this.$emit("dismissAlert");
    }
  }
}
</script>

<style scoped>

</style>