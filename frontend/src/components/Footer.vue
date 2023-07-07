<template>
  <footer class=" footer d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top mt-5 pr-1">
    <div class="col-md-4 d-flex align-items-center">
      <span class="mb-3 mb-md-0 text-muted">© 2023 Tiny Cinema</span>
    </div>
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <li class="ms-3"><a class="text-muted" href="https://github.com/LaGabor/bardi-laravel-demo"><i class="bi bi-github"></i></a></li>
      <li class="ms-3"><a class="text-muted" href="https://www.linkedin.com/in/gábor-lauter"><i class="bi bi-linkedin"></i></a></li>
      <li class="ms-3"><a class="text-muted" href="https://www.youtube.com/watch?v=MT-70ni4Ddo&ab_channel=Lucas"><i class="bi bi-youtube"></i></a></li>
    </ul>
  </footer>
</template>

<script>
export default {
  name: "Footer"
}
</script>

<style>

.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
}

.footer ul {
  margin-right: 5%;
}

.footer span {
  margin-left: 10%;
}
</style>