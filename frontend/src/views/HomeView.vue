<template>
  <PayModal @pay="tryToPay"/>
  <DatePicker @newDate="updateChosenDate"/>
  <div class="mb-5">
    <Alert :booked="bookedAlert" @dismissAlert="dismissAlert"/>
    <div v-if="seatsReservationStatus === null">
      <p class=" d-flex justify-content-center">Choose a Date!</p>
    </div>
    <div v-else>
        <SettingSeats :seats="seatsReservationStatus" @reserve="tryToReserve"/>
      <button v-if="seatsReservedByUser[0] || seatsReservedByUser[1] !== false" type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#payModal" >Pay</button>
      <button v-else type="button" class="btn btn-primary mt-5 disabled">Pay</button>
    </div>
  </div>

</template>

<script>
import DatePicker from "@/components/DatePicker.vue";
import PayModal from "@/components/PayModal.vue";
import SettingSeats from "@/components/SettingSeats.vue";
import fetchUrl from "@/fetcher/Fetch.js";
import Alert from "@/components/Alert.vue";

export default {
  name: 'HomeView',
  components: {
    Alert,
    SettingSeats,
    PayModal,
    DatePicker,
  },
  data() {
    return {
      chosenDate: null,
      seatsReservationStatus: null,
      bookedAlert: null,
      seatsReservedByUser: [false,false],
    };
  },
  methods: {
      updateChosenDate(newDate){
        this.chosenDate = newDate
        this.seatsReservedByUser = [false,false]
        this.getSeatsByDate(this.chosenDate)
        this.bookedAlert = null;
      },
      async tryToReserve(seatData){
        this.bookedAlert = null;
        let reserveStatus = await this.reserveSeatIfFree(seatData.seatId);
        if(reserveStatus === 'success'){
          this.seatsReservedByUser[seatData.seatNum] = true
          this.seatsReservationStatus[seatData.seatNum] = "reserved";
        }else{
          this.seatsReservationStatus[seatData.seatNum] = reserveStatus;
          this.bookedAlert = reserveStatus;
        }
      },
      async reserveSeatIfFree(seatId){
        return await fetchUrl.post("http://localhost:8000/api/seat/reserve", { date: this.chosenDate,seatId:seatId});
      },
      async getSeatsByDate(){
        this.seatsReservationStatus = await fetchUrl.get("http://localhost:8000/api/seats/date", { date: this.chosenDate });
      },
      dismissAlert() {
        this.bookedAlert = null;
      },
      async tryToPay(email){
        let seatsId =  this.convertIsReservedIntoIds(this.seatsReservedByUser);
        let result = await fetchUrl.put("http://localhost:8000/api/seats/buy", {date: this.chosenDate,seatsId:seatsId,email:email});
        console.log(result)
        this.afterPayAttempt(result);
        },
      convertIsReservedIntoIds(reservationList){
        let reservationListSize = 2;
        let SeatsReservedById = [];
        for(let i=0; i <reservationListSize;i++){
          if(reservationList[i]){
            SeatsReservedById.push(i+1)
          }
        }
        return SeatsReservedById;
      },
      afterPayAttempt(result){
        console.log(result)
        if(result === 1){
          this.bookedAlert = 'booked';
          this.reservationSold();
        }else{
          this.bookedAlert = 'timeout'
        }
        this.seatsReservedByUser = [false,false]
      },
    reservationSold() {
      this.seatsReservedByUser.forEach((reservationStatus,index) =>{
          if(reservationStatus === true){
           this.seatsReservationStatus[index] = 'sold';
          }
      })
    }
  }

}
</script>
