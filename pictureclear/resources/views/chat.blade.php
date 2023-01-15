@extends('layouts.app')

@section('title')
    {{ 'PictureClear - Chat' }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/styleChat.css?v=') . time() }}">
    <main class="content">
        <div class="container p-0">
            <h1 class="h3 mb-3">Messages</h1>
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">
                        <div class="px-4 d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control my-3" placeholder="Search...">
                                </div>
                            </div>
                        </div>
                        <!-- LISTA DE TODOS OS CHATS -->
                        @if ($all_chats_teacher)
                            @foreach ($all_chats_teacher as $chat)
                                <a href="{{ url('/chat', ['id' => $chat['id']]) }}"
                                    class="list-group-item list-group-item-action border-0">
                                    <div class="d-flex align-items-start">
                                        <img
										src="{{DB::select('select * from users where id =' . $chat['student_id'])[0]->picture != null ?
											 URL::asset('storage/images/'.DB::select('select * from users where id ='.$chat['student_id'])[0]->picture) :
											URL::asset('images/default-profilepicture.png')}}"
                                            class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40"
                                            style="object-fit: cover;">
                                        <div class="flex-grow-1 ml-3">
                                            {{DB::select('select * from users where id ='
											.$chat['student_id'])[0]->username}}
                                            <div class="small">
												<span class="fas fa-circle chat-online">
													</span>Online</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                        <!-- LISTA DE TODOS OS CHATS -->

                        <hr class="d-block d-lg-none mt-1 mb-0">
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img src="{{ Auth::user()->picture != null ?
									 URL::asset('storage/images/' . Auth::user()->picture) :
									  URL::asset('images/default-profilepicture.png') }}"
                                        class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40"
                                        style="object-fit: cover;">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong>{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative">
                            <div class="chat-messages p-4">

                                <!-- MENSAGENS DO USER -->
                                @foreach ($sentMessages as $message)
                                    @if ($message['user_id'] == Auth::user()->id)
                                        <div class="chat-message-right pb-4">
                                        @else
                                            <div class="chat-message-left pb-4">
                                    @endif
                                    <div>
                                        @if ($message['user_id'] == Auth::user()->id)
                                            <img src="{{ Auth::user()->picture != null ?
											 URL::asset('storage/images/' . Auth::user()->picture) :
											  URL::asset('images/default-profilepicture.png') }}"
                                                class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40"
                                                style="object-fit: cover;">
                                        @else
                                            <img src="{{ $sender['picture'] != null ?
											 URL::asset('storage/images/' . $sender['picture']) :
											  URL::asset('images/default-profilepicture.png') }}"
                                                class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40"
                                                style="object-fit: cover;">
                                        @endif
                                        <div class="text-muted small text-nowrap mt-2 info">{{ $message['sentOn'] }}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        @if ($message['user_id'] == Auth::user()->id)
                                            <div class="font-weight-bold mb-1">You</div>
                                        @else
                                            <div class="font-weight-bold mb-1">
                                                {{ $sender['firstname'] . ' ' . $sender['lastname'] }}</div>
                                        @endif
                                        {{ $message['message'] }}
                                    </div>
                            </div>
                            @endforeach
                            <!-- MENSAGENS DO USER -->



                        </div>
                    </div>

                    <form method="POST" action="{{ url('/messageSent', ['id' => $presentChatId]) }}">
                        @csrf
                        <div class="flex-grow-0 py-3 px-4 border-top">
                            <div class="input-group">
                                <input min="1" step="any" placeholder="Type your message"
                                    class="form-control @error('message') is-invalid @enderror" type="text"
                                    name="message" value="" required autocomplete="message" autofocus>
                                @error('price3')
                                    <span class="span invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
