@extends('layouts.app')

@section('title', 'Publish New Game')

@section('content')
    <h2>Publish New Game</h2>

    <form action="" method="POST">

        <div class="publish-product-form-container">
                <div class="publih-product-form-container-item">
                    <div class="label-input horizontal">
                        <label for="">Title*</label>
                        <input type="text" name="" id="">
                    </div>

                    <div class="label-input horizontal">
                        <label for="">Description</label>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="label-input horizontal">
                        <label for="">Tags</label>
                        <input type="text" name="" id="">
                    </div>

                    <div class="label-input horizontal">
                        <label for="">Contributors</label>
                        <input type="text" name="" id="">
                    </div>

                    <div class="label-input horizontal">
                        <label for="">Game File Url</label>
                        <input type="text" name="" id="">
                    </div>
                </div>

                <div class="publih-product-form-container-item">
                    
                </div>



        </div>

        <button type="submit">Save</button>
    </form>

    {{-- <div class="container3">
        <div class="container4">
            <label>Title</label>
            <input type="text"/>

            <label>Description</label>
            <input style="height:10rem;" type="text"/>

            <label>Tags</label>
            <input type="text"/>

            <label>Contributors</label>
            <input type="text"/>

            <label>Game File</label>
            <x-add-file/>
        </div>
        <div class="container4">
            <div class="right-column">
                <div class="logo-section">
                    <label>Logo</label>
                    <x-add-file/>
                </div>
                
                <div class="media-section">
                    <label>Media</label>
                    <div class="container5">
                        <x-add-file/>
                        <x-add-file/>
                        <x-add-file/>
                        <x-add-file/>
                        <x-add-file/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <button2>Publish Game</button2> --}}

        
@endsection
    {{-- <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>

    <form action="{{ route('store') }}" method="POST">
        @csrf
        <h2>Create New Item</h2>

        <!-- Basic info -->
        <label for="title">Title (required):</label><br>
        <input type="text" name="title" id="title" maxlength="64" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description"></textarea><br><br>

        <label for="upload_date">Upload Date:</label><br>
        <input type="date" name="upload_date" id="upload_date"><br><br>

        <label for="approval_date">Approval Date:</label><br>
        <input type="date" name="approval_date" id="approval_date"><br><br>

        <label for="visibility_setting">Visibility Setting (required):</label><br>
        <select name="visibility_setting" id="visibility_setting" required>
            <option value="Public">Public</option>
            <option value="Unlisted">Unlisted</option>
            <option value="Private">Private</option>
        </select><br><br>

        <label for="file_url">File URL:</label><br>
        <input type="url" name="file_url" id="file_url"><br><br>

        <!-- Images -->
        <label>Images (URLs):</label><br>
        <div id="images-wrapper">
            <input type="url" name="images[]" placeholder="Image URL">
        </div>
        <button type="button" onclick="addField('images-wrapper', 'images[]', 'url')">+ Add another image</button><br><br>

        <!-- Videos -->
        <label>Videos (URLs):</label><br>
        <div id="videos-wrapper">
            <input type="url" name="videos[]" placeholder="Video URL">
        </div>
        <button type="button" onclick="addField('videos-wrapper', 'videos[]', 'url')">+ Add another video</button><br><br>

        <!-- Tags -->
        <label>Tags:</label><br>
        <div id="tags-wrapper">
            <input type="text" name="tags[]" maxlength="32" placeholder="Tag">
        </div>
        <button type="button" onclick="addField('tags-wrapper', 'tags[]', 'text')">+ Add another tag</button><br><br>

        <!-- Collaborators -->
        <label>Collaborators (User IDs):</label><br>
        <div id="collaborators-wrapper">
            <input type="number" name="collaborators[]" placeholder="User ID">
        </div>
        <button type="button" onclick="addField('collaborators-wrapper', 'collaborators[]', 'number')">+ Add another collaborator</button><br><br>

        <button type="submit">Submit</button>
    </form>
        
    </body>
    </html>



    <script>
    function addField(wrapperId, name, type) {
        const wrapper = document.getElementById(wrapperId);
        const input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.placeholder = name.replace('[]', '');
        if (name === 'tags[]') input.maxLength = 32;
        wrapper.appendChild(document.createElement('br'));
        wrapper.appendChild(input);
    }
    </script>
    --}}
