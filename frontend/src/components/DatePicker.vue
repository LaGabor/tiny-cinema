<template>
  <div>
    <div class="d-flex justify-content-center">
      <input type="text" id="datepicker" class="form-control" placeholder="Select Date" style="display: inline;" ref="datepickerInput">
      <span class="input-group-text" id="basic-addon1" style="display: inline;" @click="handleIconClick">
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
  methods: {
    handleIconClick() {
      const datepickerInput = this.$refs.datepickerInput;
      datepickerInput.focus();
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
