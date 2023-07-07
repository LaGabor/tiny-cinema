<template>
  <ul class="list-group">
    <Seat :seatNum="seat1" :seatsStatus="seats" @reserve="reserveSeat"/>
    <Seat :seatNum="seat2" :seatsStatus="seats" @reserve="reserveSeat"/>
  </ul>
</template>

<script>
import Seat from "@/components/Seat.vue";

export default {
  name: "SettingSeats",
  components: {Seat},
  props: ["seats"],
  data(){
    return{
      seat1:0,
      seat2:1,
    }
  },
  methods:{
    reserveSeat(seatNum){
      this.$emit("reserve", seatNum);
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