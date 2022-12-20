@extends('layouts.app')

@section('title')
    {{ 'PictureClear - Editar Perfil' }}
@endsection

@section('editProfile')
    <link rel='stylesheet' href='css/styleEditProfile.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="container-login">
        <div class="form-container sign-in-container">
            <form method="POST" class="login" action="{{ url('/editarperfil/save') }}" enctype="multipart/form-data">
                @csrf
                <h1>Continuas a mesma pessoa {{ Auth::user()->firstname }}!</h1>
                <div class="submit">
                    <input placeholder="Primeiro Nome" type="text" name="firstname"
                        value="{{ $user->value('firstname') }}">
                    <input placeholder="Último nome" type="text" name="lastname" value="{{ $user->value('lastname') }}">
                    <input placeholder="E-mail" disabled type="text" name="lastname" value="{{ $user->value('email') }}">
                    <textarea maxlength="150" name="about" class="text" placeholder="Descrição"
                        value="{{ $user->value('description') }}">{{ $user->value('description') }}</textarea>
                    <button type="submit">Concluir alterações</button>
                </div>
                <!--</form>-->
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <div class="profilepicture">
                        <h1 id="photo">Wow, ainda melhor!</h1>
                        <br>
                        <img id="profilepicture" src="{{ $user->value('picture') != null ? 'storage/images/'.$user->value('picture') : 'images/default-profilepicture.png' }}"
                            alt="{{ $user->value('picture') != null ? $user->value('picture') : "default-profilepicture.png" }}">
                        <input type="file" id="profilepictureInput" name='image' style="display: none"
                            value="{{ $user->value('picture') }}">
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
        const img_profilepicture = document.querySelector('#profilepicture');
        const input_profilepictureInput = document.querySelector('#profilepictureInput');

        

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
