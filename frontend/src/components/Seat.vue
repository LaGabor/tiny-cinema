<template>
  <li class="list-group-item d-flex justify-content-between align-items-center center-li">
    Seat1
    <div class="buttons">
      <button v-if="seatsStatus[seatNum] === 'free'" type="button" class="btn btn-success" @click="reserveSeat(seatNum)">Free</button>
      <button v-if="seatsStatus[seatNum] === 'reserved'" type="button" class="btn btn-secondary disabled">Reserved</button>
      <button v-if="seatsStatus[seatNum] === 'sold'" type="button" class="btn btn-danger disabled">Sold</button>
    </div>
  </li>
</template>

<script>
export default {
  name: "Seat",
  props:["seatNum","seatsStatus"],
  methods: {
    reserveSeat(seatNum) {
      this.$emit("reserve", seatNum);
    }
  }
}
</script>

<style scoped>

</style>