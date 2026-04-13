@extends('layouts.app')

@section('content')

<style>

.container {
    max-width: 700px;
    margin: auto;
    padding: 30px;
}

.title {
    text-align: center;
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 26px;
    margin-bottom: 10px;
}

.poet {
    text-align: center;
    color: #777;
    margin-bottom: 20px;
}

.sheir {
    text-align: center;
    margin-bottom: 20px;
        position: relative;
}

.sheir .actions{
        position: absolute;
    left: right;
    left: 15px;
    top: 38%;
}

.line {
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 22px;
    line-height: 2.2;
}

@media(max-width:768px){


.kalaam-show-content {
    padding-top: 100px;
}

.title {
    position: fixed;
    top: 15px;

    left: 50%;
    transform: translateX(-50%);

    width: 92%;
    text-align: center;

    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 26px;

    background: #625c53;
    color: #fff;

    border-radius: 36px;
    padding: 15px 0;

    z-index: 999;
}
.sheir {
    text-align: center;
    margin-bottom: 20px;
    border-bottom: 1px dashed;
}
.sheir .line:last-child {
   margin-bottom: 20px;
}
</style>

<div class="row kalaam-show-content">

    <div class="title" dir="rtl">
        {{ $kalaam->title }}
    </div>

    {{-- @if($kalaam->poet_name)
        <div class="poet" dir="rtl">
            {{ $kalaam->poet_name }}
        </div>
    @endif --}}

    @php
        $sheirs = preg_split("/\n\s*\n/", trim($kalaam->content));
    @endphp

    @foreach($sheirs as $sheir)
        @php $lines = explode("\n", trim($sheir)); @endphp

        <div class="sheir" dir="rtl">
            @foreach($lines as $line)
                <div class="line">{{ $line }}</div>
            @endforeach

            <div class="actions">
                Copy
                </div>
        </div>
    @endforeach

</div>

@endsection
