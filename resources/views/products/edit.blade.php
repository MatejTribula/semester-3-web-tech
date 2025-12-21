@extends('layouts.app')

@section('title', 'Edit Game')

@section('content')
    <h2>Edit Game</h2>

    <form class="product-form" action="{{ route('update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="publish-product-form-container">
            <div class="publish-product-form-container-item">
                {{-- Title --}}
                <div class="label-input horizontal">
                    <label for="title">Title*</label>
                    <input type="text" name="title" id="title" maxlength="64" value="{{ old('title', $product->title) }}" required>
                </div>

                {{-- Description --}}
                <div class="label-input horizontal">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Visibility --}}
                <div class="label-input horizontal">
                    <label for="visibility_setting">Visibility Setting*</label>
                    <select name="visibility_setting" id="visibility_setting" required>
                        <option value="Public" {{ $product->visibility_setting === 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Unlisted" {{ $product->visibility_setting === 'Unlisted' ? 'selected' : '' }}>Unlisted</option>
                        <option value="Private" {{ $product->visibility_setting === 'Private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                {{-- Tags --}}
                <div class="label-input horizontal">
                    <label for="tags-wrapper">Tags</label>
                    <div id="tags-wrapper">
                        @php
                            $tags = old('tags', $product->tags->pluck('tag_value')->toArray() ?? []);
                            $isFirstTag = true;
                        @endphp
                        @foreach($tags as $tag)
                            @if($isFirstTag)
                                @php $isFirstTag = false; @endphp
                                <input type="text" name="tags[]" maxlength="32" value="{{ $tag }}" placeholder="Tag">
                            @else
                                <div class="deletable-field-row ">
                                    <input type="text" name="tags[]" maxlength="32" value="{{ $tag }}" placeholder="Tag">
                                    <i class="fa-solid fa-times remove-icon"></i>
                                </div>
                            @endif

                        @endforeach
                        @if(empty($tags))
                            <input type="text" name="tags[]" maxlength="32" placeholder="Tag">
                        @endif
                    </div>
                    <button type="button" onclick="addField('tags-wrapper', 'tags[]', 'text')">+ Add another tag</button>
                </div>

                {{-- Collaborators --}}
                <div class="label-input horizontal">
                    <label for="collaborators-wrapper">Contributors (User IDs)</label>
                    <div id="collaborators-wrapper">
                        {{-- Logged-in user (readonly) --}}
                        <input type="number" value="{{ $user->id }}" readonly>

                        @php
                            // Get all collaborator IDs except the first one (usually the logged-in user)
                            $collabs = old('collaborators', $product->collaborators->pluck('id')->slice(1)->toArray() ?? []);
                        @endphp

                        @foreach($collabs as $collab)
                                <div class="deletable-field-row ">
                                    <input type="number" name="collaborators[]" value="{{ $collab }}" placeholder="Collaborator ID">
                                    <i class="fa-solid fa-times remove-icon"></i>
                                </div>
                            
                        @endforeach
                    </div>
                    <button type="button" onclick="addField('collaborators-wrapper', 'collaborators[]', 'number')">+ Add another contributor</button>
                </div>

                {{-- Game File --}}
                <div class="label-input horizontal">
                    <label for="file_url">Game File URL</label>
                    <input type="url" name="file_url" id="file_url" value="{{ old('file_url', $product->file_url) }}" required>
                </div>
            </div>

            <div class="publish-product-form-container-item">
                {{-- Cover URL --}}
                <div class="label-input horizontal">
                    <label for="cover_url">Cover URL</label>
                    <input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url', $product->cover_url) }}">
                </div>

                <div class="label-input horizontal">
                    <label for="wasm_zip">WASM Bundle (ZIP)</label>
                    <input type="file" name="wasm_zip" id="wasm_zip" accept=".zip" style="display:none">
                    <div id="wasmDrop" class="download-btn" style="justify-content:center">
                        Drop ZIP here or click to select
                    </div>
                    <p id="wasmName" style="opacity:0.6">
                        @if($product->wasm_file_name)
                            Current: {{ $product->wasm_file_name }}.html
                        @endif
                    </p>
                </div>


                <div class="label-input horizontal">
                    <label for="wasm_width">Game Width</label>
                    <input type="number" name="wasm_width" id="wasm_width" value="{{ old('wasm_width', $product->wasm_width) }}">
                </div>

                <div class="label-input horizontal">
                    <label for="wasm_height">Game Height</label>
                    <input type="number" name="wasm_height" id="wasm_height" value="{{ old('wasm_height', $product->wasm_height) }}">
                </div>

                {{-- Images --}}
                <div class="label-input horizontal">
                    <label for="images-wrapper">Images (URLs)</label>
                    <div id="images-wrapper">
                        @php
                            $images = old('images', $product->images->pluck('image_url')->toArray() ?? []);
                            $isFirstImage = true;
                        @endphp
                        @foreach($images as $img)
                            @if($isFirstImage)
                                @php $isFirstImage = false; @endphp
                                <input type="url" name="images[]" value="{{ $img }}" placeholder="Image URL">
                            @else
                                <div class="deletable-field-row ">
                                    <input type="url" name="images[]" value="{{ $img }}" placeholder="Image URL">
                                    <i class="fa-solid fa-times remove-icon"></i>
                                </div>
                            @endif
                        @endforeach
                        @if(empty($images))
                            <input type="url" name="images[]" placeholder="Image URL">
                        @endif
                    </div>
                    <button type="button" onclick="addField('images-wrapper', 'images[]', 'url')">+ Add another image</button>
                </div>

                {{-- Videos --}}
                <div class="label-input horizontal">
                    <label for="videos-wrapper">Videos (URLs)</label>
                    <div id="videos-wrapper">
                        @php
                            $videos = old('videos', $product->videos->pluck('video_url')->toArray() ?? []);
                            $isFirstVideo = true;
                        @endphp
                        @foreach($videos as $video)
                            @if($isFirstVideo)
                                @php $isFirstVideo = false; @endphp
                                <input type="url" name="videos[]" value="{{ $video }}" placeholder="Video URL">
                            @else
                                <div class="deletable-field-row ">
                                    <input type="url" name="videos[]" value="{{ $video }}" placeholder="Video URL">
                                    <i class="fa-solid fa-times remove-icon"></i>
                                </div>
                            @endif
                        @endforeach
                        @if(empty($videos))
                            <input type="url" name="videos[]" placeholder="Video URL">
                        @endif
                    </div>
                    <button type="button" onclick="addField('videos-wrapper', 'videos[]', 'url')">+ Add another video</button>
                </div>
            </div>
        </div>

        <button type="submit">Save</button>
    </form>

    <form action="{{ route('destroy', $product->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-delete" type="submit">Delete</button>
</form>


    {{-- JS for dynamically adding inputs --}}
    <script>

        (function(){
            const input = document.getElementById('wasm_zip');
            const drop = document.getElementById('wasmDrop');
            const name = document.getElementById('wasmName');
            if (!input || !drop) return;
            function setName(f){ name.textContent = f?.name || ''; }
            drop.addEventListener('click', ()=> input.click());
            drop.addEventListener('dragover', e => { e.preventDefault(); drop.style.filter='brightness(1.1)'; });
            drop.addEventListener('dragleave', () => { drop.style.filter='none'; });
            drop.addEventListener('drop', e => { e.preventDefault(); drop.style.filter='none'; if (e.dataTransfer.files?.length) { input.files = e.dataTransfer.files; setName(input.files[0]); }});
            input.addEventListener('change', () => setName(input.files[0]));
            })();

        function addField(wrapperId, name, type) 
        {
            const wrapper = document.getElementById(wrapperId);
            const input = document.createElement('input');
            input.type = type;
            input.name = name;

            const fieldRow = document.createElement('div');
            fieldRow.className = 'deletable-field-row ';

            
            let placeholder = name.replace('s[]', '')
            if(name === "collaborators[]")
            {
                input.placeholder = placeholder.charAt(0).toUpperCase() + placeholder.slice(1)+ " ID";
            }else if(name === "tags[]")
            {
                input.placeholder = placeholder.charAt(0).toUpperCase() + placeholder.slice(1);
            }
            else
            {
                input.placeholder = placeholder.charAt(0).toUpperCase() + placeholder.slice(1)+ " URL";
            }

            if (name === 'tags[]') input.maxLength = 32;
            fieldRow.appendChild(input);

            const icon = document.createElement('i');
            icon.className = 'fa-solid fa-times remove-icon';
            fieldRow.appendChild(icon);

            wrapper.appendChild(fieldRow);
            

        }
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-icon')) {
                e.target.parentElement.remove();
            }
        });
    </script>
@endsection
