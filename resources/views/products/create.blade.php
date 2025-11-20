@extends('layouts.app')

@section('title', 'Publish New Game')

@section('content')
<div class="container2">
    <h2>Publish New Game</h2>
    
    <form class="publish-form" action="{{ route('store') }}" method="POST">
        @csrf

        <div class="container3">
            <div class="form-column">
                <div class="label-input horizontal">
                    <label for="title">Title*</label>
                    <input type="text" name="title" id="title" maxlength="64" required>
                </div>

                <div class="label-input horizontal">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="6"></textarea>
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
                    <label>Tags</label>
                    <div id="tags-wrapper" class="input-group">
                        <input type="text" name="tags[]" maxlength="32" placeholder="Tag">
                    </div>
                    <button type="button" class="add-btn" onclick="addField('tags-wrapper','tags[]','text')">+ Add another tag</button>
                </div>

                <div class="label-input horizontal">
                    <label>Contributors (User IDs)</label>
                    <div id="collaborators-wrapper" class="input-group">
                        <input type="number" value="{{ $user->id }}" readonly>
                        <input type="number" name="collaborators[]" placeholder="Collaborator ID">
                    </div>
                    <button type="button" class="add-btn" onclick="addField('collaborators-wrapper','collaborators[]','number')">+ Add another contributor</button>
                </div>

                <div class="label-input horizontal">
                    <label for="file_url">Game File URL*</label>
                    <input type="url" name="file_url" id="file_url" required>
                </div>

                <button type="submit" class="save-btn">Save</button>
            </div>

            <div class="right-column">
                <div class="label-input horizontal">
                    <label for="cover_url">Cover URL*</label>
                    <input type="url" name="cover_url" id="cover_url" required>
                </div>

                <div class="label-input horizontal">
                    <label>Images (URLs)</label>
                    <div id="images-wrapper" class="input-group">
                        <input type="url" name="images[]" placeholder="Image URL">
                    </div>
                    <button type="button" class="add-btn" onclick="addField('images-wrapper','images[]','url')">+ Add another image</button>
                </div>

                <div class="label-input horizontal">
                    <label>Videos (URLs)</label>
                    <div id="videos-wrapper" class="input-group">
                        <input type="url" name="videos[]" placeholder="Video URL">
                    </div>
                    <button type="button" class="add-btn" onclick="addField('videos-wrapper','videos[]','url')">+ Add another video</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function addField(wrapperId, name, type) {
    const wrapper = document.getElementById(wrapperId);
    const input = document.createElement('input');
    input.type = type;
    input.name = name;
    
    if (name === 'collaborators[]') {
        input.placeholder = 'Collaborator ID';
    } else if (name === 'tags[]') {
        input.placeholder = 'Tag';
        input.maxLength = 32;
    } else {
        input.placeholder = name.replace('[]', '').replace(/s$/, '') + ' URL';
    }
    
    wrapper.appendChild(input);
}
</script>
@endsection