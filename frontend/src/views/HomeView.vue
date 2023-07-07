<template>
  <PayModal/>
  <DatePicker @newDate="updateChosenDate"/>
  <div class="mb-5">
    <div v-if="chosenDate == null">
      <p class=" d-flex justify-content-center">Choose a Date!</p>
    </div>
    <div v-else>
        <SettingSeats :seats="seatsData" @reserve="tryToReserve"/>
      <button v-if="reserveSeat1 || reserveSeat2 !== false" type="button" class="btn btn-primary mt-5"  data-bs-toggle="modal" data-bs-target="#payModal" >Pay</button>
      <button v-else type="button" class="btn btn-primary mt-5 disabled">Pay</button>
    </div>
  </div>

</template>

<script>
import DatePicker from "@/components/DatePicker.vue";
import PayModal from "@/components/PayModal.vue";
import SettingSeats from "@/components/SettingSeats.vue";

export default {
  name: 'HomeView',
  components: {
    SettingSeats,
    PayModal,
    DatePicker,
  },
  data() {
    return {
      chosenDate: null,
      seatsData: ["free","sold"],
      reserveSeat1: false,
      reserveSeat2: false,
    };
  },
  methods: {
      updateChosenDate(newDate){
        this.chosenDate = newDate
        this.reserveSeat1 = false
        this.reserveSeat1 = false
    },
    tryToReserve(seatNum){
      this.reserveSeat1 = !this.reserveSeat1;
    },
    isSeatFree(){

    },
    async seatsByDate(){

    },
  }

}
</script>
