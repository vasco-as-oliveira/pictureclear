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
                    @php
                        $user = DB::table('users')
                            ->select('*')
                            ->where('id', $course->owner_id)
                            ->get();
                        $costumerCount = DB::select('select count(*) as contagem from sales where tier_id IN(select id from tiers where course_id='.$course->id.' )');
                        print_r($costumerCount);
                   @endphp
                    <a style="text-decoration: none;color: inherit;"
                        href={{ 'checkCourse/search?selectCourse=' . $course->id  }}>
                        <div class="container-course">
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</p>
                            <h2>Avaliação:@if ($course->rating==0) Sem avaliações @endif
                                @for ($i = 0; $i < $course->rating; $i++)
                                    <span class="fa fa-star"></span>
                                @endfor
                                {{ "(". $course->contagem .")" }}
                                
                            </h2>
                            <h2>Linguagem: {{ $course->language }}</h2>
                            <h2>Desde: {{ $price =DB::table('tiers')->where('id', $course->id)->min('price') . '€' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </form>
    </div>
@endsection
