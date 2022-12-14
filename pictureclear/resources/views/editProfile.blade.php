<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar perfil</title>
</head>
<body>
    <form method="post" action ="{{url('/editarPerfil/save')}}" enctype="multipart/form-data">
       @csrf
        <input type="file" id="image" name='image' value="{{$user->value('picture')}}">
        <img src="" id="img1">
        Primeiro nome:<input type="text" name="firstname" value="{{$user->value('firstname')}}">
        Último nome:<input type="text" name="lastname" value="{{$user->value('lastname')}}">
        Email: <input disabled type="text" name="lastname" value="{{$user->value('email')}}">
        Sobre mim: <input type="text" name="about" value="{{$user->value('description')}}">
        <input type="submit" value="Guardar alterações">
        Foto atual: <img src="storage/images/{{$user->value('picture')}}" alt="public/images/{{$user->value('picture')}}">
    </form>

    <script>
      //  const div_pfp = document.querySelector('.image');
        const img_profilepicture = document.querySelector('#img1');
        const input_profilepictureInput = document.querySelector('#image');
      //  const button_upload = document.querySelector('#upload');
     //   const h1_photo = document.querySelector('#photo');

        input_profilepictureInput.addEventListener('change', function() {
            const chosenPhoto = this.files[0];
            if (chosenPhoto) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    img_profilepicture.setAttribute('src', reader.result);
                  //  img_profilepicture.style.display = 'contents';
                });
                reader.readAsDataURL(chosenPhoto);
              //  h1_photo.style.display="contents";
            }
        });
    </script>

</body>
</html>