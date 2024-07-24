<x-base>
    <x-slot:title>Media with alt text</x-slot:title>
    <h1>Media with alt text</h1>
    <h2><a href="{{$wikiURL}}/w/index.php?title={{$pageTitle}}">{{$pageTitle}}</a></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 500px;">Media</th>
                <th>Alt text</th>
            </tr>
        </thead>
        @foreach( $media as $file=>$alt )
            <tr>
                <td>
                    <img src="{{$wikiURL}}/w/index.php?title=Special:Redirect/file/{{$file}}&width=100" alt="{{$alt}}" title="{{$alt}}" style="width:100px"/>
                    <br />
                    <a href="{{$wikiURL}}/w/index.php?title=File:{{$file}}" target="_blank">{{$file}}</a>
                </td>
                @if( $alt == '' )
                    <td class="table-danger">
                @else
                <td>
                @endif
                    {{$alt}}
                </td>
            </tr>
        @endforeach
    </table>
</x-base>
