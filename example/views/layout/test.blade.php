<html>
    <head>
        <link href="views/layout/mixedassets/prism.css" rel="stylesheet" />
        <title>App Name - @yield('title')</title>
        <style type="text/css">
            .sample-source p {
                margin: 0;
                padding: 0;
                font: initial;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <div>
            <h3>Blade Statement Samples</h3>
            <h5>Testing Simple block Section called with Yield statement</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>section('section_one_test')
                            This is testing section One
                        <span class="start-tag"></span>endsection
                        <span class="start-tag"></span>yield('section_one_test')
                    </code>
                </pre>
                @section('section_one_test')
                    This is testing section One
                @endsection
                @yield('section_one_test')
            </div>


            <h5>Testing Uncalled/Invisible Section</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>section('section_two_test')
                            This is testing section Two
                        <span class="start-tag"></span>endsection
                    </code>
                </pre>
                @section('section_two_test')
                    This is testing section Two
                @endsection
            </div>

            <h5>Testing Showable Section</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>section('sidebar')
                            This is test sidebar for overriden testing
                        <span class="start-tag"></span>show
                    </code>
                </pre>
                @section('sidebar')
                    This is test sidebar for overriden testing
                @show
            </div>

            <h5>Testing Yield Statement</h5>
            <div class="container">
                <div class="sample-source">
                    <pre>
                        <code class="language-php">
                            <span class="start-tag"></span>yield('content')
                        </code>
                    </pre>
                    @yield('content')
                </div>
            </div>
        </div>


        <div>
            Hello, {{ $name }}.
            The current UNIX timestamp is {{ time() }}.
        </div>

        <div>

            <h3>Flow Control Statement Samples</h3>
            <h5>Testing Simple If Statement</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>if (isset($records))
                            Records Variable exists
                        <span class="start-tag"></span>endif
                    </code>
                </pre>
                @if (isset($records))
                    Records Variable exists
                @endif
            </div>

            <h5>Testing Multi-If Statement</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>if (count($records) === 1)
                            I have one record!
                        <span class="start-tag"></span>elseif (count($records) <= 2)
                            I have two records!
                        <span class="start-tag"></span>elseif (count($records) > 1)
                            I have multiple records!
                        <span class="start-tag"></span>else
                            I don't have any records!
                        <span class="start-tag"></span>endif
                    </code>
                </pre>
                @if (count($records) === 1)
                    I have one record!
                @elseif (count($records) <= 2)
                    I have two records!
                @elseif (count($records) > 1)
                    I have multiple records!
                @else
                    I don't have any records!
                @endif
            </div>


            <h5>Testing Switch Statement</h5>


            <h3>Loop Statement Samples</h3>
            <h5>Testing Simple Foreach Statement</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>foreach ($records as $record)
                            <p>This is a record <span class="pp-open"></span>$record<span class="pp-end"></span></p>
                        <span class="start-tag"></span>endforeach
                    </code>
                </pre>
                @foreach ($records as $record)
                    <p>This is a record {{ $record }}</p>
                @endforeach
            </div>
            <h5>Testing Key-Value Foreach Statement</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>foreach ($records as $key => $value)
                            <p>This is a key value record record <span class="pp-open"></span>$key<span class="pp-end"></span> <span class="pp-open"></span>$value<span class="pp-end"></span></p>
                        <span class="start-tag"></span>endforeach
                    </code>
                </pre>
                @foreach ($records as $key => $value)
                    <p>This is a key value record record {{$key}} {{$value}}</p>
                @endforeach
            </div>

            <h5>Testing While Statement</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>while (list($key, $value) = each($records))
                            <p>This is a key value record record <span class="pp-open"></span>$key<span class="pp-end"></span> <span class="pp-open"></span>$value<span class="pp-end"></span></p>
                        <span class="start-tag"></span>endwhile
                    </code>
                </pre>
                @while (list($key, $value) = each($records))
                    <p>This is a key value record record {{$key}} {{$value}}</p>
                @endwhile
            </div>

            <h5>Testing C-Style For Loop</h5>
            <div class="sample-source">
                <pre>
                    <code class="language-php">
                        <span class="start-tag"></span>for ($i=0; $i < count($records); $i++)
                            <p>This is a record <span class="pp-open"></span>$record[$i]<span class="pp-end"></span></p>
                        <span class="start-tag"></span>endfor
                    </code>
                </pre>
                @for ($i=0; $i < count($records); $i++)
                    <p>This is a record {{$record[$i]}}</p>
                @endfor
            </div>

            <h5>Testing do-while Loop</h5>

          {{-- This comment will not be present in the rendered HTML --}}
        </div>

        <script type="text/javascript">
            var statementsMap = {
                'start-tag' : '@',
                'pp-open': '',
                'pp-end' : ''
            };

            for(var statement in statementsMap) {

                var tags = document.querySelectorAll("." + statement);
                var statementSymbol = statementsMap[statement];
                for(var i in tags) {
                    tags[i].textContent = statementSymbol;
                }
            }
        </script>
        <script type="text/javascript" src="views/layout/mixedassets/prism.js"></script>
    </body>
</html>
