<div class=" mx-2 p-2">

    @if($eventversion->eventversionconfig->virtualaudition)
        <h4 class="font-bold">File Uploads</h4>

        @if(! $registrant->hasApplication())

            <div style="color: red; text-align: center; border: 1px solid red;">
                The student's application must be downloaded before
                files can be uploaded.
            </div>

        @else

            <!-- ALL-SHORE CHORUS 2022 -->
            <!-- {{--
            @if($eventversion->id === 69)
                <div style="background-color: {{ $registrant->inpersonaudition && $registrant->inpersonaudition->inperson ? 'darkgreen' : 'darkred' }}; border-radius: .5rem; margin:auto; width: 66%;display: flex; ">
                    <div style="margin: auto;">
                        @if(config('app.url') === 'http://localhost')
                            <a href="{{ route('registrant.profile.store.inperson',['eventversion' => $eventversion, 'registrant' => $registrant]) }}" style="color: white; align-self: center;">
                                @if($registrant->inpersonaudition && $registrant->inpersonaudition->inperson)
                                    Click here if you wish to submit a virtual audition
                                @else
                                    Click here if you wish to audition in person.
                                @endif
                            </a>
                        @else
                            <a href="https://studentfolder.info/registrant/profile/{{ $eventversion->id }}/{{ $registrant->id }}/inperson" style="color: white; align-self: center;">
                                @if($registrant->inpersonaudition && $registrant->inpersonaudition->inperson)
                                    Click here if you wish to submit a virtual audition
                                @else
                                    Click here if you wish to audition in person.
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            @endif
--}} -->
            @if((! $registrant->inpersonaudition) || (! $registrant->inpersonaudition->inperson))
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

                        <x-mediauploads.digitalocean
                            filename="$filename"
                            videosubmissionclosed="0"
                            :filecontenttype="$filecontenttype"
                            :registrant="$registrant"
                        />

                    @endif
                </div>

                @endforeach
            @endif

        @endif
    @endif
</div>
