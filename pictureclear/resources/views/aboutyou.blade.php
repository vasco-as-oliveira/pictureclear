@extends('layouts.app')

@section('content')
    <link rel='stylesheet' href='css/styleAboutYou.css' />
    <div class="container-login">
        <div class="form-container sign-in-container">
            <form method="POST" class="login" action ="{{url('/aboutyou/save')}}" enctype="multipart/form-data">
                @csrf
                <h1>Conta-nos mais sobre ti {{ Auth::user()->firstname}}!</h1>
                <div class="submit">
                    <textarea name="description" class="text" placeholder="Eu sou @ melhor!"></textarea>
                    <button name="done" type="submit">Concluído</button>
                </div>
            <!--</form>-->
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <div class="profilepicture">
                        <h1 id="photo">Wow, que lind@!</h1>
                        <br>
                        <img src="images/default-profilepicture.png" alt="default-profilepicture" id="profilepicture">
                        <input type="file" id="profilepictureInput" style="display: none" name="inputImage">
                        <!--<button class="ghost">-->
                            <label for="profilepictureInput" id="upload">Escolhe uma foto!</label>
                        <!--</button>-->
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    <script>
        const div_pfp = document.querySelector('.profilepicture');
        const img_profilepicture = document.querySelector('#profilepicture');
        const input_profilepictureInput = document.querySelector('#profilepictureInput');
        const button_upload = document.querySelector('#upload');
        const h1_photo = document.querySelector('#photo');

        input_profilepictureInput.addEventListener('change', function() {
            const chosenPhoto = this.files[0];
            if (chosenPhoto) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    img_profilepicture.setAttribute('src', reader.result);
                });
                reader.readAsDataURL(chosenPhoto);
                h1_photo.style.display="contents";
            }
        });
    </script>
@endsection
