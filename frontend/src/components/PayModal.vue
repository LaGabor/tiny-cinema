<template>
  <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-coin"></i> Pay</h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cancel"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="pay">
            <div class="form-group">
              <label for="paymail"><i class="bi bi-envelope-at"></i> Email</label>
              <input type="email" class="form-control" placeholder="sample@samplemail.com" id="paymail" v-model="email" required>
            </div>
            <div class="modal-footer">
              <button type="button" id='cancelButton' class="btn btn-danger" data-bs-dismiss="modal" @click="cancel">Close</button>
              <button type="submit" class="btn btn-success" @click="pay">Pay</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PayModal",
  data() {
    return {
      email: ''
    };
  },
  methods: {
    pay() {
      if(this.isValidEmail()){
        let email = this.email;
        this.$emit("pay", email);
        this.closeModal();
      }
    },
    isValidEmail() {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(this.email);
    },
    cancel(){
      this.email = '';
    },
    closeModal() {
      const cancelButton = document.getElementById('cancelButton');
      const event = new MouseEvent('click');
      cancelButton.dispatchEvent(event);
    }
  }
}
</script>

<style>

.bi-coin{
  font-size: 110%;
}

</style>






