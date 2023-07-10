<template>
  <PayModal @pay="tryToPay"/>
  <DatePicker @refresh="refresh" @newDate="updateChosenDate"/>
  <div className="mb-5">
    <Alert :booked="bookedAlert" @dismissAlert="dismissAlert"/>
    <div v-if="seatsReservationStatus === null">
      <p className=" d-flex justify-content-center">Choose a Date!</p>
    </div>
    <div v-else-if="seatsReservationStatus === false" className="spinner-border text-primary" role="status">
      <span className="sr-only"></span>
    </div>
    <div v-else>
      <SettingSeats :seats="seats" :reservationsStatus="seatsReservationStatus" @reserve="tryToReserve"/>
      <button v-if="seatsReservedByUser[0] === false && seatsReservedByUser[1] === false" type="button"
              className="btn btn-primary mt-5 disabled">Pay
      </button>
      <button v-else-if="finalizationAtTheMoment === false" type="button" className="btn btn-primary mt-5"
              data-bs-toggle="modal" data-bs-target="#payModal">Pay
      </button>
      <button v-else className="btn btn-primary mt-5 disabled" type="button" disabled>
        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
      </button>
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
      seatsReservedByUser: [false, false],
      finalizationAtTheMoment: false,
      seats: null
    };
  },
  methods: {
    updateChosenDate(newDate) {
      this.chosenDate = newDate
      this.seatsReservationStatus = false
      this.seatsReservedByUser = [false, false]
      this.getSeatsByDate()
      this.bookedAlert = null;
    },
    async tryToReserve(seatData) {
      this.bookedAlert = null;
      let reserveStatus = await this.reserveSeatIfFree(seatData.seatId);
      if (reserveStatus === 'success') {
        this.seatsReservedByUser[seatData.seatNum] = true
        this.seatsReservationStatus[seatData.seatNum] = "reserved";
      } else {
        this.seatsReservationStatus[seatData.seatNum] = reserveStatus;
        this.bookedAlert = reserveStatus;
      }
    },
    async reserveSeatIfFree(seatId) {
      return await fetchUrl.post("http://localhost:8000/api/seat/reserve", {date: this.chosenDate, seatId: seatId});
    },
    async getSeatsByDate() {
      let result = await fetchUrl.get("http://localhost:8000/api/seats/date", {date: this.chosenDate});
      this.seatsReservationStatus = result['reservationsStatus'];
      this.seats = result['seats'];
    },
    dismissAlert() {
      this.bookedAlert = null;
    },
    async tryToPay(email) {
      let seatsId = this.convertIsReservedIntoIds(this.seatsReservedByUser);
      this.finalizationAtTheMoment = true;
      let result = await fetchUrl.put("http://localhost:8000/api/seats/buy", {
        date: this.chosenDate,
        seatsId: seatsId,
        email: email
      });
      this.afterPayAttempt(result);
    },
    convertIsReservedIntoIds(reservationList) {
      let reservationListSize = 2;
      let SeatsReservedById = [];
      for (let i = 0; i < reservationListSize; i++) {
        if (reservationList[i]) {
          SeatsReservedById.push(i + 1)
        }
      }
      return SeatsReservedById;
    },
    afterPayAttempt(result) {
      if (result['booked'] === true) {
        this.bookedAlert = 'booked';
        this.reservationSold();
      } else {
        this.bookedAlert = 'timeout'
        this.seatsReservationStatus = result['reservationsStatus'];
      }
      this.seatsReservedByUser = [false, false]
      this.finalizationAtTheMoment = false;
    },
    reservationSold() {
      this.seatsReservedByUser.forEach((reservationStatus, index) => {
        if (reservationStatus === true) {
          this.seatsReservationStatus[index] = 'sold';
        }
      })
    },
    refresh() {
      if (this.chosenDate !== null) {
        this.seatsReservedByUser = [false, false]
        this.getSeatsByDate()
      }
    }
  }

}
</script>
