@extends('layouts.app')
@section('content')


<link rel="stylesheet" href="{{asset('css/styleCreateCourse.css?v=').time()}}">

<div class="container-fluid container-register" id="container-register">
<div class="form-container sign-up-container">
    
            <form id="fileUploadForm" method="POST" action="{{ url('/addLesson/create', ['id'=>$id]) }}" class="form register" enctype="multipart/form-data">
                @csrf
                <h1 class="h1">Cria uma aula</h1>

                <input id="title" placeholder="Titulo" class="input @error('title') is-invalid @enderror" type="text"
                    name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                @error('title')
                    <span class="span invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="description" placeholder="Descrição do curso" class="input @error('description') is-invalid @enderror" type="text"
                    name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>

                @error('description')
                    <span class="span invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


                
                <input type="file" id="filevid" style="display: none;"  name="inputvideo">
                <label for="filevid" class="btnAdd">Carregar Video</label>
                <div class="form-group">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>
                </div>
                <button class="button" type="submit" class="registerbtn">
                    {{ __('Criar Curso') }}
                </button>
            </form>
    </div>
</div>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('#fileUploadForm').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                          return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete: function (xhr) {
                        console.log('File has uploaded');
                    }
                });
            });
        });
    </script> -->
@endsection
