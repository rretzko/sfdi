@props([

])
<form action='https://api.sproutvideo.com/v1/videos'
      method='post'
      enctype='multipart/form-data'
      class="p-3 "
>

@csrf
<!-- {{--
                            <input type="hidden" name="token"
                                   value="{{ $fileserver->token($filecontenttype, $eventversion) }}"/>
--}} -->
    <input type="hidden" name="download_sd" value="true"/>
    <input type="hidden" name="download_hd" value="true"/>
    <input type="hidden" name="title"
           value="{{ $filename.$filecontenttype->descr}}.mp3"/>
<!-- {{--
                            <input type="hidden" name="folder_id"
                                   value="{{ $folders->where('filecontenttype_id',$filecontenttype->id)->first()->folder_id }}">
--}} -->
    <div class="form-group">
        <input type="file"
               id="filecontenttype_{{ $filecontenttype->id }}"
               name="audio" accept="audio/mp3"/>
        <div class="text-small text-muted">
            @if($eventversion->eventversionconfig->audiofiles)
                <span
                    class="hint">ONLY .mp3 files accepted</span>
            @elseif($eventversion->eventversionconfig->videofiles)
                <span class="hint">ONLY .mp4/.mov files accepted</span>
            @else
                <span
                    class="hint">No file uploads accepted{{$eventversion->eventversionconfig->audiofiles}}</span>
            @endif
        </div>
    </div>

    {{-- SAVE BUTTON --}}
    <div class="flex justify-end">
        @if($videosubmissionclosed)
            <div style="background: gray; color: white;" >
                Video submission is closed
            </div>
        @else
            <input
                class="bg-black text-white border rounded px-4 cursor-pointer"
                style="background: black; color: white;border-radius: .5rem; cursor: pointer;"
                type="submit" name="submit"
                value="Upload {{ ucwords($filecontenttype->descr) }}"
            />
        @endif
    </div>

</form>
