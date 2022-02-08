@props([
'filename',
'filecontenttype',
'registrant',
'videosubmissionclosed' => true,
])

<form action='{{ route('registrant.mediaupload.update', ['registrant' => $registrant, 'filecontenttype' => $filecontenttype]) }}'
      method='post'
      enctype='multipart/form-data'
      class="p-3 "
>

    @csrf

    <input type="hidden" name="title"
           value="{{ $filename.$filecontenttype->descr}}.mp3"/>

    <input type="file" name="{{ $filecontenttype->descr }}">

    {{-- SAVE BUTTON --}}
    <div class="flex justify-end mt-2">
        @if($videosubmissionclosed)
            <div class="px-2" style="background: gray; color: white;" >
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
