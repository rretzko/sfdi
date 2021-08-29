<div id="tdr_form">
    <form class="" method="post" action="{{route('registrant.update', ['registrant' => $registrant])}}">
        @csrf
        
        @if(count($errors))
            <div class="form-group row ml-1 col-10 border border-danger pl-1 pr-1 text-danger">
                Errors have been found and are highlighted in red.
            </div>
        @endif
        
        <div class="card m-t-40 mb-2">
            <div class="card-body">
                <h4 class="mt-0 header-title">Audition Profile</h4>
        
                <!-- NAME -->
                <div class="form-group row">
                    <label for="name" class="col-12 ml-1 col-form-label">Name (as it will appear in the program)</label>
                    <div class="row col-sm-12 ml-1">
                        <input name="programname" id="programname" value="{{ $registrant->auditiondetail->programname }}" />                
                    </div>

                </div>

                <!-- GRADE/CLASS -->
                <div class="form-group">
                    <div class="col-11 ml-2 ">
                        Grade/Class: 
                        <strong>
                            {{ $registrant->student->gradeClassOf }} 
                            ({{ $registrant->student->class_of }})
                        </strong>
                        <span class="text-small text-muted italic">Change on 
                            <a href=" {{ route('registrant.profile.edit', [
                                'registrant' => $registrant,
                                ]) }}"
                            >
                                Students Profile
                            </a>
                            if necessary
                        </span>
                    </div>
                </div>

                <!-- HEIGHT -->
                @if($requiredheight)
                    <div class="form-group">
                        <div class="col-11 ml-2 ">
                            Height: 
                            <strong>
                                {{ $registrant->student->heightFootInches }}
                            </strong>
                                <span class="text-small text-muted italic">Change on 
                            <a href=" {{ route('registrant.optional.edit', [
                                'registrant' => $registrant,
                                ]) }}"
                            >
                                Students Profile Options
                            </a>
                            if necessary
                        </span>
                        </div>
                    </div>
                @endif

                <!-- SHIRT SIZE -->
               @if($requiredshirtsize)
                    <div class="form-group">
                        <div class="col-11 ml-2 ">
                            Shirtsize: 
                            <strong>
                                {{ $registrant->student->shirtsizeDescr }}
                            </strong>
                                <span class="text-small text-muted italic">Change on 
                            <a href=" {{ route('registrant.optional.edit', [
                                'registrant' => $registrant,
                                ]) }}"
                            >
                                Students Profile Options
                            </a>
                            if necessary
                        </span>
                        </div>
                    </div>
                @endif

                <!-- PRONOUN -->
                <div class="col-11 ml-2 ">
                    Pronoun: 
                    <strong>
                        {{ $pronoun }}
                    </strong>
                        <span class="text-small text-muted italic">Change on 
                            <a href=" {{ route('registrant.profile.edit', [
                                'registrant' => $registrant,
                                ]) }}"
                            >
                                Students Profile
                            </a>
                            if necessary
                        </span>
                </div>
            </div>
        </div>

        <!-- VOICINGS AND INSTRUMENTS -->
        <div class="card m-t-40 mb-2">
            <div class="card-body">
                <h4 class="mt-0 header-title">Audition 
                    @if($choral && $instrumental)
                        @if($auditioncount < 2) Voice Part and Instrument @else Voice Parts and Instruments @endif 
                    @elseif($instrumental)
                        @if ($auditioncount < 2) Instrument @else Instruments @endif
                    @else
                        @if ($auditioncount < 2) Voice Part @else Voice Parts @endif
                    @endif
                </h4>

                <div class="form-group row" style="margin-top: 45px;">
                    <div class="col">
                        
                        @if($auditioncount > 1)<span class="font-13 text-muted col-form-sublabel"> Primary</span> @endif
                        <select name="chorals[]" id="chorals_0" 
                                class="form-control">
                            <option value="0">Select</option>
                            @foreach($chorals AS $part)                                              
                                <option value="{{$part->id}}"
                                {{($part->id == $registrant_chorals[0]) ? 'SELECTED' : ''}}
                                    >{{$part->ucwordsDescription}}</option>
                            @endforeach  
                        </select>
                    </div>
                    @if($auditioncount > 1)
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Secondary</span>
                            <select name="chorals[]" id="chorals_1" 
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($chorals AS $part)                                              
                                    <option value="{{$part->id}}"
                                    {{($part->id == $registrant_chorals[1]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach  
                            </select>
                        </div>
                    @else <input type="hidden" name="chorals[]" value="0" />
                    @endif
                    
                    @if($auditioncount > 2)
                        <div class="col">
                            <span class="font-13 text-muted col-form-sublabel">Alternate</span>
                            <select name="chorals[]" id="chorals_2" 
                                    class="form-control">
                                <option value="0">Select</option>
                                @foreach($chorals AS $part)                                              
                                    <option value="{{$part->id}}"
                                    {{($part->id == $registrant_chorals[2]) ? 'SELECTED' : ''}}
                                        >{{$part->ucwordsDescription}}</option>
                                @endforeach  
                            </select>
                        </div>
                    @else <input type="hidden" name="chorals[]" value="0" />
                    @endif
                </div><!-- form-group row-->
                
                <!-- INSTRUMENTALS PLACEHOLDER -->
                <input type="hidden" name="instrumentals[]" value="0" />
                <input type="hidden" name="instrumentals[]" value="0" />
                <input type="hidden" name="instrumentals[]" value="0" />
                
            </div><!-- card-body -->
        </div>
        
        <!-- SAVE REGISTRATION OPTIONS -->
        <div class="ml-4"><x-buttonSaveCancelChangesComponent /></div>
        
    </form><!-- Audition qualities -->

        <div class="card m-t-40 mb-2" style="background-color: rgba(0, 0, 0, .05);">
            <div class="card-body">
                <h4 class="mt-0 header-title">Application 
                    <span class="text-muted italic" style="font-size: 1rem">
                        (Save any changes BEFORE downloading application!)
                    </span>
                </h4>
                
                <div>
                    <a href="{{route('pdf.application',['registrant' => $registrant])}}" class="btn btn-primary waves-effect waves-light">Download Application</a>
                </div>
                
            </div>
        </div>
        
        <!-- VIDEO REVIEWS -->
        @if($eventversion->hasVideos)
            <div class="card m-t-40 mb-2" style="background-color: rgba(200, 150, 255, .05);">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Videos
                    </h4>

                    <div class="form-group column" style="margin-top: 45px;">
                        
                        @foreach($eventversion->videos AS $videotype)
                            <div class="form-group " style="border-bottom: 1px solid darkgrey;">
                                <h5>{{ ucwords($videotype->descr) }}</h5>
                                <div class="video_player " >
                                    @if($registrant->hasVideotype($videotype))
                                        <div class="player_stats row col-12" >
                                            <div class="player col-lg-7 ">
                                                {!! $registrant->video($videotype)['fembed_code'] !!}
                                            </div>
                                            <div class="stats col-lg-5" >
                                                <div class="items mb-3">
                                                    <div class="data_row col-12">
                                                        <div class="registrant">{{ $registrant->auditiondetail->programname }}</div>
                                                        <div class="filenname">{{ $registrant->video($videotype)['title'] }}</div>
                                                        <div class="duration">{{ number_format($registrant->video($videotype)['duration'],0) }} seconds</div>
                                                    </div>
                                                </div>
                                                <div class="col-12 row justify-between" >
                                                    <div class="approved col-7">
                                                        <input type="checkbox" 
                                                            class="form-check-input approved" 
                                                            name="approved" 
                                                            id="approved_{{$videotype->id}}" 
                                                            value="approved" 
                                                            server_id="{{ $registrant->video($videotype)['id'] }}" 
                                                            {{ $registrant->video($videotype)['approved'] ? "CHECKED" : '' }}
                                                        />
                                                        <label class="form-check-label">Approved</label>
                                                    </div>
                                                    <div class="rejected col-5 " server_id="{{ $registrant->video($videotype)['id'] }}" >
                                                        <span class="text-danger" 
                                                           style="font-size: .8rem; cursor:pointer;" 
                                                           title="Reject this video"    
                                                           >
                                                            Reject
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else 
                                        <form action='https://api.sproutvideo.com/v1/videos'
                                              method='post' 
                                              enctype='multipart/form-data' 
                                              class="p-3 shadow-lg rounded"
                                              style="background-color: rgba(255, 0, 0, .05);">    
                                          
                                            @csrf
                                            
                                            <input type="hidden" name="token" value="{{ $videoserver->token($videotype) }}" />
                                         
                                            <div class="form-group">
                                                <input type="file" id="video_{{ $videotype->id }}" name="video" accept="video/mp4,video/mov"  /> 
                                                <div class="text-small text-muted">.mp4 and .mov files accepted</div>
                                            </div>
                                            <x-button-save-changes-component value="Upload {{ ucwords($videotype->descr) }} Video" />
                                        </form>
                                    @endif
                                </div>
                                
                            </div>
                        @endforeach
                            
                    </div>     
                </div><!-- card-body -->
            </div>
        @endif
        
        

        
</div><!-- tdr_form -->