@extends('layouts.app')

@section('title')
    {{ 'PictureClear - Setup perfil' }}
@endsection

@section('content')
    <link rel='stylesheet' href='css/styleAboutYou.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="container-login">
        <div class="form-container sign-in-container">
            <form method="POST" class="login" action="{{ url('/aboutyou/save') }}" enctype="multipart/form-data">
                @csrf
                <h1>Conta-nos mais sobre ti {{ Auth::user()->firstname }}!</h1>
                <div class="submit">
                    <textarea maxlength="150" name="description" class="text" placeholder="Eu sou @ melhor!"></textarea>
                    <button name="done" type="submit">Concluído</button>
                </div>
                <!--</form>-->
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <button class="close"><i class="fa fa-close"></i></button>
                    <div class="profilepicture">
                        <h1 id="photo">Wow, que lind@!</h1>
                        <br>
                        <img src="images/default-profilepicture.png" alt="default-profilepicture" id="profilepicture">
                        <input type="file" id="profilepictureInput" style="display: none" name="inputImage">
                        <!--<button class="ghost" id="upload">-->
                        <label for="profilepictureInput" class="upload">
                            <button class="ghost" id="upload">
                                Escolhe uma foto!
                            </button>
                        </label>
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
                const i = Math.floor(Math.random() * 2);
                if (i == 1) {
                    document.getElementById("photo").innerHTML = "Wow, estás compremetid@?"
                }
                h1_photo.style.display = "contents";
            }
        });
    </script>
@endsection
