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
                          @if($card->isfree)
                          <form method="GET" id="bookAClass" action="{{ url('/schedule/reserve', ['id' => $schedule->course_id, '$slotId' => $card->id]) }}"
                          enctype="multipart/form-data">
                              @csrf
                              <button form="bookAClass" type="submit" id="viewClasses"
                                  class="btn btn-primary btn-book">Reservar hora</button>
                          </form>
                          @else
                          <button form="bookAClass" type="submit" id="viewClasses"
                                  class="btn btn-secondary btn-book">Hora já reservada!</button>
                          @endif
                          <div class="timetable-item-like">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <div class="timetable-item-like-count">11</div>
                          </div>
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