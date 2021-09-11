<div class=" mx-2 p-2">

    @if($eventversion->eventversionconfig->virtualaudition)
        <h4 class="font-bold">File Uploads</h4>

        @if(! $registrant->hasApplication())

            <div class="advisory">
                The student's application must be downloaded before
                files can be uploaded.
            </div>

        @else

            @foreach($eventversion->filecontenttypes AS $filecontenttype)

                <div class="shadow-lg rounded border-2 mb-4">
                    <h3 class="pl-2 pt-1">
                        {{ ucwords($filecontenttype->descr) }}
                        {{-- SOLO/QUARTET/etc have titles (ex. The Siver Swan --}}
                        {{-- SCALES might have NO title --}}
                        @if(strlen($filecontenttype->pivot->title))
                            : <span
                                class="font-bold">{{ $filecontenttype->pivot->title }}</span>
                        @endif
                    </h3>

                    @if($registrant->hasFileUploaded($filecontenttype))
                        {{-- START VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT --}}
                        <div class="w-full">
                            <div class="flex justify-center">
                                {!! $registrant->fileviewport($filecontenttype) !!}
                            </div>

                            <div class="stats col-lg-4 ml-1">
                                <div class="flex mx-2 my-4 justify-around">
                                    @if($registrant->fileuploadapproved($filecontenttype))
                                        <div class="text-green-700 text-xs font-bold bg-green-100 p-2">
                                            Approved: {{ $registrant->fileuploadapprovaltimestamp($filecontenttype) }}
                                        </div>
                                    @endif
                                </div>
                                {{-- END VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT VIEWPORT --}}
                                @else
                                    <form action='https://api.sproutvideo.com/v1/videos'
                                          method='post'
                                          enctype='multipart/form-data'
                                          class="p-3 "
                                    >

                                        @csrf

                                        <input type="hidden" name="token"
                                               value="{{ $fileserver->token($filecontenttype, $eventversion) }}"/>
                                        <input type="hidden" name="download_sd" value="true"/>
                                        <input type="hidden" name="download_hd" value="true"/>
                                        <input type="hidden" name="title"
                                               value="{{ $filename.$filecontenttype->descr}}.mp3"/>
                                        <input type="hidden" name="folder_id"
                                               value="{{ $folders->where('filecontenttype_id',$filecontenttype->id)->first()->folder_id }}">

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
                                            <input
                                                class="bg-black text-white border rounded px-4 cursor-pointer"
                                                style="background: black; color: white;border-radius: .5rem; cursor: pointer;"
                                                type="submit" name="submit"
                                                value="Upload {{ ucwords($filecontenttype->descr) }}"
                                            />
                                        </div>

                                    </form>
                                @endif
                            </div>

                            @endforeach
                            @endif
                            @endif
                        </div>
