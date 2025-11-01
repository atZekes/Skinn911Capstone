@extends('layouts.clientapp')

@section('content')
<div class="container" style="max-width:900px;margin:30px auto;padding:20px;background:#fff;border:1px solid #eee;">
    <h3>Help & Chat</h3>
    <p>Choose a preset FAQ or write a message to chat with staff/bot.</p>

    <div style="display:flex;gap:20px;">
        <div style="flex:1;">
            <h4>Presets</h4>
            <div id="presets"></div>
        </div>
        <div style="flex:2;">
            <h4>Conversation</h4>
            <div id="messages" style="height:300px;overflow:auto;border:1px solid #ddd;padding:10px;background:#fafafa;"></div>
            <div style="margin-top:10px;display:flex;gap:8px;">
                <input id="chat-input" placeholder="Type your message" style="flex:1;padding:8px;" />
                <button id="send-btn" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>

</div>

@endsection
