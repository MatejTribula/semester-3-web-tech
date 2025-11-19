@props(['type' => 'url', 'name' => null, 'id' => null, 'wrapper' => null, 'logo' => false])

<div class="card add-game-card add-file-card"
     role="button"
     tabindex="0"
     data-type="{{ $type }}"
     data-name="{{ $name ?? '' }}"
     data-id="{{ $id ?? '' }}"
     data-wrapper="{{ $wrapper ?? '' }}"
     data-logo="{{ $logo ? '1' : '0' }}">
    <div class="card-img">
        <i class="fa-solid fa-plus plus-icon"></i>
    </div>
</div>

<script>

</script>