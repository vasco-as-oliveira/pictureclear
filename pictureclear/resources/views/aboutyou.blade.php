@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="css/styleAboutYou.css">
    <div class="container-aboutyou" id="container-aboutyou">
        <div class="form-container about-container">
            <form method="POST" class="aboutyou">
                @csrf
                <div class="aboutyou">
                    <h1>Conta-nos mais sobre ti!</h1>
                    <div class="submit">
                        <input type="text">
                        <button type="submit">Concluído</button>
                    </div>
                    <div class="profilepicture">
                        <img src="images/default-profilepicture.png" alt="default-profilepicture" id="profilepicture">
                        <input type="file" id="profilepictureInput">
                        <label for="profilepictureInput" id="upload">Escolhe uma foto!</label>
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

        div_pfp.addEventListener('mouseenter', function() {
            button_upload.style.display = "block";
        });

        div_pfp.addEventListener('mouseleave', function() {
            button_upload.style.display = "none";
        });

        input_profilepictureInput.addEventListener('change', function() {
            const chosenPhoto = this.files[0];
            if (chosenPhoto) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    img_profilepicture.setAttribute('src', reader.result);
                });
                reader.readAsDataURL(chosenPhoto);
            }
        });
    </script>
@endsection
