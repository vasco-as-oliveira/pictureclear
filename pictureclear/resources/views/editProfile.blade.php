<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar perfil</title>
</head>
<body>
    <form method="get" action ="{{url('/editarPerfil/save')}}">

        <div class="profilepicture">
            <h1 id="photo">Wow!</h1>
            <br>
            <img src="images/default-profilepicture.png" alt="default-profilepicture" id="profilepicture">
            <input type="file" id="profilepictureInput" style="display: none">
            <button class="ghost">
                <label for="profilepictureInput" id="upload">Escolhe uma foto!</label>
            </button>
        </div>

        Primeiro nome:<input type="text" name="firstname" value="{{$user->value('firstname')}}">
        Último nome:<input type="text" name="lastname" value="{{$user->value('lastname')}}">
        Email: <input disabled type="text" name="lastname" value="{{$user->value('email')}}">
        Sobre mim: <input type="text" name="about" value="{{$user->value('description')}}">
        <input type="submit" value="Guardar alterações">
    </form>

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

</body>
</html>