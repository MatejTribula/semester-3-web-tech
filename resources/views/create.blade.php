@extends('layouts.app')

@section('title', 'Publish New Game')

@section('content')
    <h2>{{ 'Publish New Game' }}</h2>

    <div class="container3">
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
    
    <button2>Publish Game</button2>

        
@endsection
