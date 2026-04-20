@extends('layouts.app')

@section('content')

<style>

/* 🌙 Background vibe */
body {
    background: linear-gradient(135deg, #1c1c1c, #2c2c2c);
    color: #fff;
}

/* 📦 Container */
.container {
    max-width: 700px;
    margin: auto;
    padding: 20px;
}

/* 🏷 Title */
.title {
    text-align: center;
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 28px;
    margin-bottom: 20px;
    background: rgba(255,255,255,0.08);
    padding: 12px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

/* 🎙 Poet */
.poet {
    text-align: center;
    color: #ccc;
    margin-bottom: 25px;
}

/* 🎵 Sheir block */
.sheir {
    position: relative;
    padding: 18px 10px;
    margin-bottom: 18px;
    border-radius: 15px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(6px);
    transition: 0.3s;
}

.sheir:hover {
    background: rgba(255,255,255,0.1);
}

/* ✍️ Lines */
.line {
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 22px;
    line-height: 2.4;
    text-align: center;
}

/* 📋 Copy Button */
.actions {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    opacity: 0.7;
}

.actions:hover {
    opacity: 1;
}

/* 📱 Mobile */
@media(max-width:768px){

.title {
    position: sticky;
    top: 10px;
    z-index: 1000;
    font-size: 24px;
}

.line {
    font-size: 20px;
}

}

</style>

<div class="container kalaam-show-content">

    <div class="title" dir="rtl">
        {{ $kalaam->title }}
    </div>

    @php
        $sheirs = preg_split("/\n\s*\n/", trim($kalaam->content));
    @endphp

    @foreach($sheirs as $sheir)
        @php $lines = explode("\n", trim($sheir)); @endphp

        <div class="sheir" dir="rtl">

            <div class="sheir-text">
                @foreach($lines as $line)
                    <div class="line">{{ $line }}</div>
                @endforeach
            </div>

            <div class="actions" onclick="copySheir(this)">
                <i data-feather="copy"></i>
            </div>

        </div>
    @endforeach

</div>

{{-- Copy Script --}}
<script>
function copySheir(el) {
    let sheirDiv = el.closest('.sheir');
    let text = '';

    sheirDiv.querySelectorAll('.line').forEach(function(line) {
        text += line.innerText + "\n";
    });

    navigator.clipboard.writeText(text.trim()).then(function () {

        el.innerHTML = '<i data-feather="check"></i>';
        feather.replace();

        setTimeout(() => {
            el.innerHTML = '<i data-feather="copy"></i>';
            feather.replace();
        }, 1500);

    });
}
</script>

@endsection
