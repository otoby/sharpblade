<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('section_one_test')
            This is testing section One
        @endsection
        @section('section_two_test')
            This is testing section Two
        @endsection
        @section('sidebar')
            This is test sidebar for overriden testing
        @show

        <div class="container">
            @yield('section_one_test')
            @yield('content')
        </div>
        <div>
        Hello, {{ $name }}.
        The current UNIX timestamp is {{ time() }}.
        </div>
        <div>
          <Control Structure Testing>

          <all if else testing>
          @if (count($records) === 1)
              I have one record!
          @elseif (count($records) <= 2)
              I have two records!
          @elseif (count($records) > 1)
              I have multiple records!
          @else
              I don't have any records!
          @endif

          <all loop testing>
          <foreach without key>
          @foreach ($records as $record)
              <p>This is a record {{ $record }}</p>
          @endforeach

          <foreach with key value pair>
          @foreach ($records as $key => $value)
              <p>This is a key value record record {{$key}} {{$value}}</p>
          @endforeach

          <while loop>
          @while (list($key, $value) = each($records))
              <p>This is a key value record record {{$key}} {{$value}}</p>
          @endwhile

          <for loop>
          @for ($i=0; $i<count($records); $i++)
              <p>This is a record {{ $record[$i] }}</p>
          @endfor

          {{-- This comment will not be present in the rendered HTML --}}
        </div>
    </body>
</html>
