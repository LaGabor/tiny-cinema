<template>
  <li class="list-group-item d-flex justify-content-between align-items-center center-li">
    Seat{{ seatId }}
    <div class="buttons">
      <button v-if="seatsStatus[seatNum] === 'free'" type="button" class="btn btn-success" @click="reserveSeat()">Free</button>
      <button v-if="seatsStatus[seatNum] === 'reserved'" type="button" class="btn btn-secondary disabled">Reserved</button>
      <button v-if="seatsStatus[seatNum] === 'sold'" type="button" class="btn btn-danger disabled">Sold</button>
    </div>
  </li>
</template>

<script>
export default {
  name: "Seat",
  props:["seatId","seatsStatus"],
  methods: {
    reserveSeat() {
      this.$emit("reserve", {"seatId":this.seatId,"seatNum":this.seatNum});
    }
  },
  data(){
    return{
      seatNum: this.seatId-1,
    }
  }
}
</script>

<style scoped>



</style>