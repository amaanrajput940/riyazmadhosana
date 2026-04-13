@extends('layouts.app')

@section('content')

<style>
.app {
    display: flex;
    height: 100vh;
}
   .kalaam-heading {
    text-align: center;
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 22px;
    color: #2c2c2c;
    margin-bottom: 15px;
    line-height: 2;
}

/* Author muted style */
.kalaam-heading .author {
display: block;
    font-size: 14px;
    color: inherit;
    margin-top: 5px;
    font-family: sans-serif;
    letter-spacing: 0.3px;
    opacity: 0.70;
}
/* Sidebar */
.sidebar {
    width: 320px;
    border-right: 1px solid #eee;
    overflow-y: auto;
    padding: 15px;
    background: #fff;
}
@media(max-width:768px){


.sidebar {
    width: 100%;
    border-right: 1px solid #eee;
    overflow-y: auto;
    padding: 15px;
    background: #fff;
    height: 100vh;
}
    .sidebar h4 {
        font-size: 20px;
        margin-bottom: 15px;
        background-color: #625c53;
        color: #ffffff;
        padding: 15px;
        border-radius: 24px;

    }

    .kalaam-item {
        background: #efefef;
        border-right:5px solid #625c53
    }
    .kalaam-item:nth-child(odd) {
    border-right: 5px solid #625c53;
    border-left: none;
}

/* Even items → left border */
.kalaam-item:nth-child(even) {
    border-left: 5px solid #625c53;
    border-right: none;
}

    .kalaam-item:active {
        transform: scale(0.98);
        background: #eef1ff;
    }
}

    .sidebar h4 {
        font-size: 20px;
        margin-bottom: 15px;
        background-color: #625c53;
        color: #ffffff;
        padding: 15px;
        border-radius: 24px;

    }

.kalaam-item {
    background: #efefef;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 10px;
    transition: all 0.25s ease;
    border: 2px solid transparent;
}

/* Hover */
.kalaam-item:hover {
    background: #f3f5ff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

/* Odd → right border */
.kalaam-item:nth-child(odd):hover {
    border-right: 5px solid #625c53;
}

/* Even → left border */
.kalaam-item:nth-child(even):hover {
    border-left: 5px solid #625c53;
}

.kalaam-item.active {
    background: #e9ecff;
    font-weight: bold;
}

/* Content */
.content {
    flex: 1;
    padding: 20px;
    background: #f7f8fc;
}

iframe {
    width: 100%;
    height: 85vh;
    border: none;
    border-radius: 12px;
    background: #fff;
}

/* Mobile */
@media(max-width:768px){
    .app {
        flex-direction: column;
    }

    .content {
        display: none;
    }
    .kalaam-heading {
    text-align: center;
    font-family: 'Noto Nastaliq Urdu', serif;
    font-size: 22px;
    color: #2c2c2c;
    margin-bottom: 10px;
    line-height: 2;
    font-weight: 800;
}

/* Author muted style */
.kalaam-heading .author {
    display: block;
    font-size: 14px;
    color: inherit;
    margin-top: 0px;
    font-family: sans-serif;
    letter-spacing: 0.3px;
    opacity: 0.70;
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
