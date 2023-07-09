@component('mail::message')

    @if(count($seatsId) == 1)
        You Successfully Reserved seat {{$seatsId[0]}} on {{$date}}.
    @else
        You Successfully Reserved the Room on {{$date}}.
    @endif
@endcomponent
