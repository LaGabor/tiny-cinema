<template>
  <div class="mb-5">
    <div class="d-flex justify-content-center">
      <span class="input-group-text" id="basic-addon1" style="display: inline;" @click="refreshDateReserveStatus">
        <i class="bi bi-bootstrap-reboot"></i>
      </span>
      <input type="text" id="datepicker" class="form-control" placeholder="Select Date" style="display: inline;" ref="datepickerInput" v-model="selectedDate">
      <span class="input-group-text" id="basic-addon1" style="display: inline;" @click="chooseDate">
        <i class="bi bi-calendar-date-fill"></i>
      </span>
    </div>
  </div>
</template>
<script>
export default {
  name: "DatePicker",
  mounted() {
    const datepickerInput = this.$refs.datepickerInput;
    flatpickr(datepickerInput, {
      minDate: 'today',
      maxDate: new Date().fp_incr(7),
    });
  },
  data() {
    return {
      selectedDate: ""
    };
  },
  watch: {
    selectedDate(newDate) {
      this.dateChanger(newDate);
    }
  },
  methods: {
    chooseDate() {
      const datepickerInput = this.$refs.datepickerInput;
      datepickerInput.focus();
    },
    dateChanger(newDate) {
      this.$emit("newDate", newDate);
    },
    refreshDateReserveStatus(){
      this.$emit('refresh')
    }
  }
}
</script>

<style>
#datepicker {
  display: flex;
  text-align: center;
  max-width: 21%;
}

#basic-addon1:hover{
  cursor: pointer;
}
</style>
