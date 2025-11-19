@extends('layouts.app')

@section('title', 'Publish New Game')

@section('content')
    <h2>{{ 'Publish New Game' }}</h2>
    <form action="{{ route('store') }}" method="POST">
    @csrf
        <div class="container3">
            <div class="container4">
                <label>Title</label>
                <input style = "height: 2rem;" type="text" name="title" id="title" maxlength="64" required>

                <label>Description</label>
                <textarea style = "height: 10rem;" name="description" id="description"></textarea>

                
                    <label>Tags:</label>
                    <div>
                        <div id="tags-wrapper">
                        </div>
                        <button style = "width:100%;" type="button" onclick="addField('tags-wrapper', 'tags[]', 'text', 'Tag')">+ Add another tag</button>
                    </div>

                <label>Collaborators:</label>
                <div>
                    <div id="collaborators-wrapper">
                    </div>
                    <button style = "width:100%;" type="button" onclick="addField('collaborators-wrapper', 'collaborators[]', 'number', 'User ID')">+ Add another collaborator</button>
                </div>

                <label>Game File</label>
                <x-add-file type="url" name="file_url" id="file_url"/>

                <label for="visibility_setting">Visibility Setting:</label>
                <select name="visibility_setting" id="visibility_setting" required>
                    <option value="Public">Public</option>
                    <option value="Unlisted">Unlisted</option>
                    <option value="Private">Private</option>
                </select>

                <input value = "{{ date('Y-m-d') }}" type="hidden" name="upload_date" id="upload_date" hidden>
                <input value = "" type="hidden" name="approval_date" id="approval_date" hidden>
            </div>
            <div class="container4">
                <div class="right-column">
                    <div class="logo-section">
                        <label>Logo</label>
                        <x-add-file type="url" name="logo" id="logo" logo="true"/>
                    </div>
                    
                    <div class="media-section">
                        <label>Images</label>
                        <div class="container5">
                            <x-add-file wrapper="images-wrapper" type="url" name="images[]"/>
                        </div>
                    </div>

                    <div class="media-section">
                        <label>Videos</label>
                        <div class="container5">
                            <x-add-file wrapper="videos-wrapper" type="url" name="videos[]"/>
                        </div>
                    </div>

                    <div id="images-wrapper">
                    </div>

                    <div id="videos-wrapper">
                    </div>

                    <div id="logo-wrapper">
                    </div>

                </div>
            </div>
        </div>
        <button type="submit">Publish Game</button>
     </form>
        
@endsection 

<script>
document.addEventListener('DOMContentLoaded', function() 
{
    // ensure initial fields exist
    if (document.getElementById('tags-wrapper') && !document.getElementById('tags-wrapper').querySelector('.field-row')) 
    {
        addField('tags-wrapper', 'tags[]', 'text', 'Tag');
    }
    if (document.getElementById('collaborators-wrapper') && !document.getElementById('collaborators-wrapper').querySelector('.field-row')) 
    {
        addField('collaborators-wrapper', 'collaborators[]', 'number', 'User ID');
        const firstInput = document.querySelector('#collaborators-wrapper .field-row input');
        if (firstInput) firstInput.value = "{{ auth()->id() }}";
        if (firstInput) firstInput.readOnly = true;
    }
});
</script>

