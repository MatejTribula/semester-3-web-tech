@props(['imageSources' => []])

<div class="carousel">
    <div class="carousel-img"></div>
    <div class="carousel-progress"></div>
</div>

<script>
  window.imageSources = @json($imageSources);
</script>
<script src="{{ asset('js/carousel.js') }}"></script>