<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
</head>
<body>

<form action="{{ route('update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <h2>Edit Product</h2>

    <!-- Basic info -->
    <label for="title">Title (required):</label><br>
    <input type="text" name="title" id="title" maxlength="64" value="{{ old('title', $product->title) }}" required><br><br>

    <label for="description">Description:</label><br>
    <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea><br><br>

    <label for="upload_date">Upload Date:</label><br>
    <input type="date" name="upload_date" id="upload_date" value="{{ old('upload_date', $product->upload_date) }}"><br><br>

    <label for="approval_date">Approval Date:</label><br>
    <input type="date" name="approval_date" id="approval_date" value="{{ old('approval_date', $product->approval_date) }}"><br><br>

    <label for="visibility_setting">Visibility Setting (required):</label><br>
    <select name="visibility_setting" id="visibility_setting" required>
        <option value="Public" {{ old('visibility_setting', $product->visibility_setting) === 'Public' ? 'selected' : '' }}>Public</option>
        <option value="Unlisted" {{ old('visibility_setting', $product->visibility_setting) === 'Unlisted' ? 'selected' : '' }}>Unlisted</option>
        <option value="Private" {{ old('visibility_setting', $product->visibility_setting) === 'Private' ? 'selected' : '' }}>Private</option>
    </select><br><br>

    <label for="file_url">File URL:</label><br>
    <input type="url" name="file_url" id="file_url" value="{{ old('file_url', $product->file_url) }}"><br><br>

    <!-- Images -->
    <label>Images (URLs):</label><br>
    <div id="images-wrapper">
        @if(!empty($product->images))
            @foreach($product->images as $image)
                <input type="url" name="images[]" value="{{ $image->image_url }}" placeholder="Image URL"><br>
            @endforeach
        @else
            <input type="url" name="images[]" placeholder="Image URL">
        @endif
    </div>
    <button type="button" onclick="addField('images-wrapper', 'images[]', 'url')">+ Add another image</button><br><br>

    <!-- Videos -->
    <label>Videos (URLs):</label><br>
    <div id="videos-wrapper">
        @if(!empty($product->videos))
            @foreach($product->videos as $video)
                <input type="url" name="videos[]" value="{{ $video->video_url }}" placeholder="Video URL"><br>
            @endforeach
        @else
            <input type="url" name="videos[]" placeholder="Video URL">
        @endif
    </div>
    <button type="button" onclick="addField('videos-wrapper', 'videos[]', 'url')">+ Add another video</button><br><br>

    <!-- Tags -->
    <label>Tags:</label><br>
    <div id="tags-wrapper">
        @if(!empty($product->tags))
            @foreach($product->tags as $tag)
                <input type="text" name="tags[]" maxlength="32" value="{{ $tag->tag_value }}" placeholder="Tag"><br>
            @endforeach
        @else
            <input type="text" name="tags[]" maxlength="32" placeholder="Tag">
        @endif
    </div>
    <button type="button" onclick="addField('tags-wrapper', 'tags[]', 'text')">+ Add another tag</button><br><br>

    <!-- Collaborators -->
    <label>Collaborators (User IDs):</label><br>
    <div id="collaborators-wrapper">
        @if(!empty($product->collaborators))
            @foreach($product->collaborators as $collaborator)
                <input type="number" name="collaborators[]" value="{{ $collaborator->id }}" placeholder="User ID"><br>
            @endforeach
        @else
            <input type="number" name="collaborators[]" placeholder="User ID">
        @endif
    </div>
    <button type="button" onclick="addField('collaborators-wrapper', 'collaborators[]', 'number')">+ Add another collaborator</button><br><br>

    <button type="submit">Update</button>
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
