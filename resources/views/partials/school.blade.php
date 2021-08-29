<div class="card">
                
    <div class="card-header" role="tab" id="schoolheading">
        <h3>
            <a data-toggle="collapse" data-parent="accordion" 
               href="#school" aria-expanded="true" 
               aria-controls="school">School</a>
        </h3>
    </div><!-- card-header -->

    <div id="school" class="collapse {{$nav_links['school']}}" role="tabpanel"
         aria-labelledby="schoolheading">
        <div class="card-block">

            <form class="bg-white text-dark" method="post" 
                action="addSchoolForm" >
                @csrf

                <div class="container">

                    <fieldset class="form-group">

                        <!-- SCHOOLS TABLE -->
                        {!!$table!!} 
                        
                        <!-- SUBMIT --> 
                        <div class="form-group d-flex flex-column">
                            <div class="form-row">
                                <div class="col">
                                   <button class="btn btn-primary" type="submit">Add School</button>
                                </div>
                            </div>
                            @if(session()->has('message'))
                                <p class="help text-success">{!!session()->get('message')!!}</p>
                            @else
                                <p class="help invisible">placeholder</p>
                            @endif
                       </div>

                    </fieldset>

                </div><!-- container --> 
            </form>

        </div>

    </div>

</div><!-- card -->


