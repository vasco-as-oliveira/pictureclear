<link rel="stylesheet" href="{{asset('css/stylePlayer.css?v=').time()}}">


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container-fluid content">
    <div class="card">
        <div class="container-fluid firstinfo"> 
            <video controls id="videoLesson">
                <source src="{{URL::asset('storage/videos/'.$lesson->url.'')}}" type="video/mp4">
                    Your browser does not support the video tag.
            </video>
            <div class="profileinfo">
                <h1>{{$lesson->title}}</h1>
                <h3>{{$lesson->created_at}}</h3>
                <p class="bio">{{$lesson->description}}</p>
            </div>
        </div>
    </div>
    <div class="badgescard"> 
        
            <a href="{{ url()->previous() }}">Voltar</a>

    </div>
</div>