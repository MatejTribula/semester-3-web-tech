@extends('layouts.app')

@section('title', 'Publish New Game')

@section('content')
    <h2>Publish New Game</h2>

    <form class="product-form" action="{{ route('store') }}" method="POST">
        @csrf

        <div class="publish-product-form-container">
            <div class="publish-product-form-container-item">
                <div class="label-input horizontal">
                    <label for="title">Title*</label>
                    <input type="text" name="title" id="title" maxlength="64" required>
                </div>

                <div class="label-input horizontal">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </div>

                <div class="label-input horizontal">
                    <label for="visibility_setting">Visibility Setting*</label>
                    <select name="visibility_setting" id="visibility_setting" required>
                        <option value="Public">Public</option>
                        <option value="Unlisted">Unlisted</option>
                        <option value="Private">Private</option>
                    </select>
                </div>

                <div class="label-input horizontal">
                    <label for="tags-wrapper">Tags</label>
                    <div id="tags-wrapper">
                        <input type="text" name="tags[]" maxlength="32" placeholder="Tag">
                    </div>
                    <button type="button" onclick="addField('tags-wrapper', 'tags[]', 'text')">+ Add another tag</button>
                </div>

                <div class="label-input horizontal">
                    <label for="collaborators-wrapper">Contributors (User IDs)</label>
                    <div id="collaborators-wrapper">
                        <input type="number" value="{{ $user->id }}" readonly>
                    </div>
                    <button type="button" onclick="addField('collaborators-wrapper', 'collaborators[]', 'number')">+ Add another contributor</button>
                </div>

                <div class="label-input horizontal">
                    <label for="file_url">Game File URL *</label>
                    <input type="url" name="file_url" id="file_url" required>
                </div>
            </div>

            <div class="publish-product-form-container-item">
                <div class="label-input horizontal">
                    <label for="cover_url">Cover URL*</label>
                    <input type="url" name="cover_url" id="cover_url" required>
                </div>

                <div class="label-input horizontal">
                    <label for="wasm_file_name">WASM File name</label>
                    <input type="text" name="wasm_file_name" id="wasm_file_name">
                </div>

                <div class="label-input horizontal">
                    <label for="wasm_width">Game Width</label>
                    <input type="number" name="wasm_width" id="wasm_width">
                </div>

                <div class="label-input horizontal">
                    <label for="wasm_height">Game Height</label>
                    <input type="number" name="wasm_height" id="wasm_height">
                </div>

                <div class="label-input horizontal">
                    <label for="images-wrapper">Images (URLs)</label>
                    <div id="images-wrapper">
                        <input type="url" name="images[]" placeholder="Image URL">
                    </div>
                    <button type="button" onclick="addField('images-wrapper', 'images[]', 'url')">+ Add another image</button>
                </div>

                <div class="label-input horizontal">
                    <label for="videos-wrapper">Videos (URLs)</label>
                    <div id="videos-wrapper">
                        <input type="url" name="videos[]" placeholder="Video URL">
                    </div>
                    <button type="button" onclick="addField('videos-wrapper', 'videos[]', 'url')">+ Add another video</button>
                </div>
            </div>
        </div>

        <button type="submit">Save</button>
    </form>

    <script>
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