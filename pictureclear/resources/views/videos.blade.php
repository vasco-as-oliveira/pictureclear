@extends('layouts/app')


@section('title')
     videospage 
@endsection

@section('content')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
	integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/styleVideos.css?v=').time()}}">



<div class="container" id="classes">
<div class="row">
	<div class="col-lg-12">
		<div class="main-box clearfix">
			<div class="table-responsive">
				<table class="table user-list">
					<thead>
						<tr>
							<th class="text-center"><span>Nome</span></th>
							<th class="text-center"><span>Criado em</span></th>
							<th class="text-center"><span>Descrição</span></th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					
					
                    @foreach($result as $lesson)
						<tr>
							<td class="text-center" style="width: 20%;">
							<span class="label label-default">{{$lesson->title}}</span>
							</td>
							<td>
                                {{$lesson->created_at}}
							</td>
							<td class="text-center">
								<span class="label label-default">{{$lesson->description}}</span>
							</td>
							<td class="text-center" style="width: 10%;">
							<form method="POST" action="{{ url('/player',
								['courseId'=>$lesson->course_id,'videoid'=>$lesson->id]) }}"
								enctype="multipart/form-data">
								@csrf
								<button type="submit" class="label checkbox btn btn-success">Assistir Aula</button>
							</form>
							</td>
						</tr>


                        
                    @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
                        <!-- Script to change the url of the video -->
<script>

    function changeVideo(element) {

		
        document.getElementById("classes").style.filter = "blur(10px)";
        document.getElementById("videoPlayer").style.display = "block";
        document.getElementById("videoPlayer").style.zIndex = "9999";
        document.getElementById("classes").style.display = "none";
    }

    function closePlayer(element) {
        document.getElementById("videoPlayer").style.display = "none";
        document.getElementById("classes").style.display = "block";
        document.getElementById("classes").style.filter = "blur(0px)";

    }

</script>

@endsection