@extends ('layouts.app')

@section('title')
    {{ 'PictureClear - Feed' }}
@endsection

@section('content')
    <link rel='stylesheet' href='css/styleFeed.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div>
        <form action="">
            @php
                $courses = DB::table('courses')
                    ->select('*')
                    ->get();
                
            @endphp
            <div class="courses">
                @foreach ($courses as $course)
                @if($course->public)
                    @php
                        $user = DB::table('users')
                            ->select('*')
                            ->where('id', $course->owner_id)
                            ->get();
                        $costumerCount = DB::select('select count(*) as contagem from course_ratings where course_id=' . $course->id);
                        //print_r($costumerCount);
                    @endphp
                    <div class="container-course">
                        <a style="text-decoration: none;color: inherit;"
                            href={{ 'checkCourse/search?selectCourse=' . $course->id }}>
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</p>
                            <h2>Avaliação: 
                                @if ($course->rating == 0)
                                    Sem avaliações
                                @endif
                                @for ($i = 0; $i < $course->rating; $i++)
                                    <span class="fa fa-star"></span>
                                @endfor
                                {{ '(' . $costumerCount[0]->contagem . ')' }}

                            </h2>
                            <h2>Linguagem: {{ $course->language }}</h2>
                            <h2>Desde: {{ $price =DB::table('tiers')->where('course_id', $course->id)->min('price') . '€' }}</p>
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </form>
    </div>
    <script>
        var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        infinteLoadMore(page);
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });
        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "/blogs?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    if (response.length == 0) {
                        $('.auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
@endsection
