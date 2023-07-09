<template>
  <header class=" py-3 mb-5 border-bottom">
    <span id="silly-span" class="icon-class">
      <i class="bi bi-film"></i>
    </span>
    <span class="fs-4"> Tiny Cinema </span>
  </header>
</template>

<script>
import homeView from "../views/HomeView.vue";

export default {
  name: "Header",
  computed: {
    homeView() {
      return homeView
    }
  }
}
</script>

<style>

</style>