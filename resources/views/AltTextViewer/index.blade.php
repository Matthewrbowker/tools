<x-base>
    <form method="post" action="{{ route('alttextviewer.submit') }}">
        @csrf
        <div class="form-group">
            <label for="page">Page title</label>
            <input type="text" class="form-control" id="page" name="page" placeholder="Enter page title">
        </div>
        <div class="form-group">
            <label for="wikiURL">Wiki URL</label>
            <input type="text" class="form-control" id="wikiURL" name="wikiURL" placeholder="Enter wiki URL">
        </div>
        <div class="form-group">
            <label for="mode">Parser mode: </label>
            <input type="radio" id="mode" name="mode" value="wikitext" checked /> Wikitext
            <input type="radio" id="mode" name="mode" value="html" /> HTML
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-base>
