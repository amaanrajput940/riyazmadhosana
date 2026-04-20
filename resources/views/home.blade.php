@extends('layouts.app')

@section('content')

<style>
.app {
    display: flex;
    height: 100vh;
    background: #0f0f0f;
}

/* Heading */
.kalaam-heading {
    text-align: center;
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 22px;
    color: #f1f1f1;
    margin-bottom: 15px;
    line-height: 2;
}

/* Author */
.kalaam-heading .author {
    display: block;
    font-size: 13px;
    margin-top: 5px;
    font-family: sans-serif;
    opacity: 0.6;
}

/* Sidebar */
.sidebar {
    width: 320px;
    border-right: 1px solid #222;
    overflow-y: auto;
    padding: 15px;
    background: #121212;
}

/* Scrollbar (nice touch 😎) */
.sidebar::-webkit-scrollbar {
    width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
    background: #333;
    border-radius: 10px;
}

/* Sidebar heading */
.sidebar h4 {
    font-size: 20px;
    margin-bottom: 15px;
    background: linear-gradient(320deg, #181614, #1e1b17);
    color: #fff;
    padding: 15px;
    border-radius: 20px;
    border: 5px solid #625c53;
}

/* Kalaam Item */
.kalaam-item {
    background: #1c1c1c;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 12px;
    color: #e5e5e5;
    transition: all 0.25s ease;
    border: 1px solid transparent;
    cursor: pointer;
}

/* Hover */
.kalaam-item:hover {
    background: #262626;
    box-shadow: 0 6px 18px rgba(0,0,0,0.5);
}

/* Active */
.kalaam-item.active {
    background: linear-gradient(135deg, #625c53, #3e3a35);
    color: #fff;
    font-weight: bold;
}

/* Odd/Even borders (subtle) */
.kalaam-item:nth-child(odd):hover {
    border-right: 3px solid #625c53;
}
.kalaam-item:nth-child(even):hover {
    border-left: 3px solid #625c53;
}

/* Content */
.content {
    flex: 1;
    padding: 20px;
    background: #0f0f0f;
}

/* Iframe */
iframe {
    width: 100%;
    height: 85vh;
    border: none;
    border-radius: 12px;
    background: #1c1c1c;
}

/* 📱 Mobile */
@media(max-width:768px){

.app {
    flex-direction: column;
}

.sidebar {
    width: 100%;
    height: 100vh;
}

.content {
    display: none;
}

.kalaam-heading {
    font-size: 22px;
    font-weight: 800;
}

.kalaam-item {
    background: #1c1c1c;
}

/* Alternating borders */
.kalaam-item:nth-child(odd) {
    border-right: 4px solid #625c53;
}
.kalaam-item:nth-child(even) {
    border-left: 4px solid #625c53;
}

}
</style>

<div class="app">

    <!-- Sidebar -->
    <div class="sidebar">

       <h4 class="kalaam-heading" dir="rtl">
     ریاضِ مدح و ثنا
   <span class="author">Author: {{env('AUTHOR_NAME')}}</span>
</h4>

        @foreach($kalaams as $item)
            <div class="kalaam-item"
                 data-slug="{{ $item->slug }}">
                {{ $item->title }}
            </div>
        @endforeach

    </div>

    <!-- Content -->
    <div class="content">
        <iframe id="frame"></iframe>
    </div>

</div>

@endsection

@push('scripts')




<script>
    var rootUrl = "{{ config('app.app_root_url') }}";
document.addEventListener('DOMContentLoaded', function () {

    const frame = document.getElementById('frame');

    function loadKalaam(slug, isMobile = false) {

        let url = rootUrl + "/kalaam/" + slug;

        if (isMobile) {
            window.location.href = url;
            return;
        }

        frame.src = url;

        // URL update
        window.history.pushState({}, '', rootUrl + '/kalaam?slug=' + slug);
    }

    // Click events
    document.querySelectorAll('.kalaam-item').forEach(item => {

        item.addEventListener('click', function () {

            let slug = this.dataset.slug;
            let isMobile = window.matchMedia("(max-width:768px)").matches;

            // active state
            document.querySelectorAll('.kalaam-item')
                .forEach(i => i.classList.remove('active'));

            this.classList.add('active');

            loadKalaam(slug, isMobile);
        });

    });

    // 🔥 Refresh state restore
    let params = new URLSearchParams(window.location.search);
    let slug = params.get('slug');

    if (slug) {
        frame.src = "/kalaam/" + slug;

        document.querySelectorAll('.kalaam-item').forEach(item => {
            if (item.dataset.slug === slug) {
                item.classList.add('active');
            }
        });
    }

});
</script>
@endpush
