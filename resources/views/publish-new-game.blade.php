@extends('layouts.app')

@section('title', 'Publish New Game')

@section('content')
    <h2>{{ 'Publish New Game' }}</h2>

    <div class="container3">
        <div class="container4">
            <label>Title</label>
            <input type="text"/>

            <label>Description</label>
            <input type="text"/>

            <label>Tags</label>
            <input type="text"/>

            <label>Contributors</label>
            <input type="text"/>

            <label>Game File</label>
            <x-add-game-card/>
        </div>
        <div class="container4">
            <label>Add logo</label>
            <x-add-game-card/>

            <label>Media</label>
            <div class="container4">
                <x-add-game-card/>
            </div>
        </div>
    </div>
    
    <button style="button" width="20" height="1rem">Publish Game</button>

        
@endsection
