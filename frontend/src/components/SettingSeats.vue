<template>
  <ul class="list-group">
    <Seat v-for="seat in seats" :seatId="seat.id" :seatsStatus="reservationsStatus" @reserve="reserveSeat"/>
  </ul>
</template>

<script>
import Seat from "@/components/Seat.vue";

export default {
  name: "SettingSeats",
  components: {Seat},
  props: ["seats","reservationsStatus"],
  methods:{
    reserveSeat(seatData){
      this.$emit("reserve", seatData);
    }
  }
}
</script>

<style>

li{
  max-width: 30%;
}

.list-group {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.center-li {
  width: 25%;
  max-width: 25%;
}

</style>