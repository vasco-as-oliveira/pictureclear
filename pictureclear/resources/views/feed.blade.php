@extends ('layouts.app')

@section('title')
    {{ 'PictureClear - Feed' }}
@endsection

@section('content')
    <link rel='stylesheet' href='css/styleFeed.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div>
        {!! $courses->links('pagination::bootstrap-4') !!}
        <form>
            <select name="dropdown" onchange="this.form.submit()">
                <option value="id_asc">Criação Ascendente</option>
                <option value="id_asc">Criação Descendente</option>
                <option value="price_asc">Preço Ascendente</option>
                <option value="price_desc">Preço Descendente</option>
                <option value="rating_asc">Rating Ascendente</option>
                <option value="rating_desc">Rating Descendente</option>
            </select>
        </form>
        <div class="courses">
            @foreach ($courses as $course)
                @if ($course->public)
                    @php
                        $user = DB::table('users')
                            ->select('*')
                            ->where('id', $course->owner_id)
                            ->get();
                        $costumerCount = DB::select('select count(*) as contagem from sales where tier_id
                            IN(select id from tiers where course_id=' . $course->id . ' )');
                        //print_r($costumerCount);
                    @endphp
                    <div class="container-course">
                        <a style="text-decoration: none;color: inherit;"
                            href={{ 'checkCourse/search?selectCourse=' . $course->id }}>
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</p>
                            <h2>Avaliação:@if ($course->rating == 0)
                                    Sem avaliações
                                @endif
                                @for ($i = 0; $i < $course->rating; $i++)
                                    <span class="fa fa-star"></span>
                                @endfor
                                {{ '(' . $costumerCount[0]->contagem . ')' }}

                            </h2>
                            <h2>Linguagem: {{ $course->language }}</h2>
                            <h2>Desde:
                                {{ $price =DB::table('tiers')->where('course_id', $course->id)->min('price') . '€' }}
                                </p>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
