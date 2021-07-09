
@unless (empty($name))
<h1>Nie jest puste</h1>
    
@endunless
@empty(!$name)
<h1>Jest puste</h1>
@endempty
@isset($name1)
    
@endisset
@switch($name)
    @case('Damian')
        <h1>TO damian</h1>
        @break
    @case('Kots')
        <h1>TO nie damian</h1>
        @break
    @default
        <h1>TO </h1>
@endswitch
@forelse ($names as $name )
    <h1>{{$name}}</h1>
@empty
    <h1>Nie ma imion</h1>
@endforelse
{{ $i=0 }}
@while ($i<10)
    <h1>{{ $i }}</h1>
    {{ $i++; }}
@endwhile