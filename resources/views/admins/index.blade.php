<div>
    @if(auth()->id() === 2626)

        <h2 class="font-bold text-lg mb-1">Log In As</h2>

        <div class="w-12/12">

            {{-- ERRORS --}}
            @if($errors->any())
                <div style="background-color: rgba(255,0,0,0.1); color: rgba(255,0,0,0,1); padding: 0 0.5rem; width: 50%; margin: 0.5rem 0;">
                    {{ implode('',$errors->all(':message')) }}
                </div>
            @endif

            <form method="post" action="{{ route('impersonate') }}">

                @csrf

                <div>
                    <label class="w-6/12" for="search">Search</label>
                    <input type="text" name="username" placeholder="Enter username">
                    <input type="submit" name="submit" id="submit" value="Submit"/>
                </div>
            </form>
        </div>

    {{--
        <div class="w-full flex flex-col">
            @if(isset($loginas) && $loginas->count())
                <label class="" for="">Results </label>
                <div class="">
                    <ul>
                        @foreach($loginas AS $person)
                            <li>
                                @if(config('app.url') === 'http://localhost')
                                    <form action="{{ route('impersonate.login', [$person->user_id]) }}" method="post">
                                        @else
                                            <form action="https://thedirectorsroom.com/impersonation/{{ $person->user_id }}" method="post">
                                                @endif
                                                @csrf
                                                <button class="bg-gray-400 text-black px-2 rounded" type="submit">
                                                    Impersonate {{ $person->fullName.' ('.$person->user_id.')' }}
                                                </button>
                                            </form>

                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif
        </div>
        --}}
    @else
        <h2>You are not authorized to perform this action</h2>
    @endif
</div>

