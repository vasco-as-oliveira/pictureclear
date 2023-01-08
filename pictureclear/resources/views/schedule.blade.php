@extends('layouts.app')

@section('title')
    {{ 'PictureClear - Chat' }}
@endsection

@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styleSchedule.css?v=') . time() }}">
<div class="idance">
    <div class="schedule content-block">
        <div class="container">
            <h2 data-aos="zoom-in-up" class="aos-init aos-animate">Schedule</h2>
        
            <div class="timetable">
        
              <!-- Schedule Top Navigation -->
              <nav class="nav nav-tabs">
              {{ $schedule_slots->links() }}
              </nav>

              <div class="tab-content">
                <div class="tab-pane show active">
                  <div class="row">

                 
                    <!-- Schedule Item -->
                    @foreach($schedule_slots as $card)
                    <div class="col-md-6">
                      <div class="timetable-item">
                        <div class="timetable-item-main">
                          <div class="timetable-item-time">Dia {{explode(" ", $card->begin)[0]}}</div>
                          <div class="timetable-item-name">Começa às {{explode(" ", $card->begin)[1]}} e termina às {{explode(" ", $card->end)[1]}}</div>
                          
                          
                          
                          <!-- Student can book if it's not booked previously -->
                          @if($card->isfree)
                            @if($schedule->user_id != Auth::user()->id)
                              <form method="GET" id="bookAClass" action="{{ url('/schedule/reserve', ['id' => $schedule->course_id, '$slotId' => $card->id]) }}"
                              enctype="multipart/form-data">
                                  @csrf
                                  <button form="bookAClass" type="submit" id="viewClasses"
                                      class="btn btn-primary btn-book">Reservar hora</button>
                              </form>
                            @else
                              <form method="POST" id="deleteClass" action="{{ url('/schedule_slot_delete', ['id' => $schedule->course_id, '$slotId' => $card->id]) }}"
                              enctype="multipart/form-data">
                                  @csrf
                                  <button form="deleteClass" type="submit"
                                      class="btn btn-primary btn-book">Apagar Hora</button>
                              </form>
                            @endif
                          @else
                            @if($schedule->user_id == Auth::user()->id)
                              <div class="timetable-item-name">Aula marcada por {{'@'.DB::select('select * from users where id = ?', [$card->student_id])[0]->username}}</div>
                            @endif
                          <button form="bookAClass" type="button" id="viewClasses"
                                  class="btn btn-secondary btn-book">Hora já reservada!</button>
                          @endif
                       
                        </div>
                      </div>
                    </div>
                    @endforeach
                    <!-- Schedule Item -->
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
  @endsection