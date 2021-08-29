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
                            <!-- {{--
                                                                    <div class="items mb-3">
                                                                        <div class="data_row col-12">
                                                                            <div
                                                                                class="registrant">{{ $registrant->auditiondetail->programname }}</div>
                                                                            <div
                                                                                class="filenname">{{ $registrant->video($videotype)['title'] }}</div>
                                                                            <div
                                                                                class="duration">{{ number_format($registrant->video($videotype)['duration'],0) }}
                                                                                seconds
                                                                            </div>
                                                                            <div
                                                                                class="approved_at">{{ $registrant->video($videotype)['approved'] }}</div>
                                                                        <!-- {-- <div class="server_id">{{ $registrant->video($videotype)['id'] }}<div> --} -->
                                                                        </div>
                                                                    </div>
--}} -->
                                <div class="flex mx-2 my-4 justify-around">
                                    @if($registrant->fileuploadapproved($filecontenttype))
                                        <div class="text-green-700 text-xs font-bold bg-green-100 p-2">
                                            Approved: {{ $registrant->fileuploadapprovaltimestamp($filecontenttype) }}
                                        </div>
                                    @else
                                        <a href="{{ route('fileupload.approve',['registrant' => $registrant, 'filecontenttype' => $filecontenttype]) }}">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            >
                                                Approve
                                            </button>
                                        </a>
                                    @endif
                                    <a href="{{ route('fileupload.reject',['registrant' => $registrant, 'filecontenttype' => $filecontenttype]) }}">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        >
                                            Reject
                                        </button>
                                    </a>
                                <!-- {{--
                                                                        <div class="approved col-7">
                                                                            <input type="checkbox"
                                                                                   class="form-check-input approved"
                                                                                   name="approved"
                                                                                   id="approved_{{$filecontenttype->id}}"
                                                                                   value="approved"
                                                                                   server_id="{{ $registrant->fileuploads->where('filecontenttype_id', $filecontenttype->id)->first()->server_id }}"
                                                                                {{ $registrant->fileuploads->where('filecontenttype_id',$filecontenttype->id)->first()->approved ? "CHECKED" : '' }}
                                                                            />
                                                                            <label
                                                                                class="form-check-label">Approved</label>
                                                                        </div>

                                                                        <div class="rejected col-11 ml-1 "
                                                                             server_id="{{ $registrant->video($videotype)['id'] }}">
                                                        <span class="text-danger"
                                                              style="font-size: .8rem; cursor:pointer;"
                                                              title="Reject this video"
                                                        >
                                                            Reject
                                                        </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                --}} -->
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
