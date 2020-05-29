{{--<pre>{{print_r($weekDays)}}</pre>--}}

@foreach($involvements as $involvement)
    <pre>
        {{$involvement->association}}
        {{$involvement->student}}
        @if($results = findValue([$involvement->association], ['association'], $weekDays))
            @php
                $start = (new \DateTime())->modify('-7 day');
                $end = (new \DateTime())->modify('+7 day');
                $weekDays_prep = [];
                foreach ($results as $result) {
                    //if($result->weekday == 7) $result->weekday = 0;
                    $weekDays_prep[] = $result->weekday;
                }
                print_r($start);
                print_r($end);
                print_r($weekDays_prep);
                print_r(generateDates($start, $end, $weekDays_prep));
            @endphp
            {{print_r($weekDays_prep)}}
        @endif
    </pre>
@endforeach
