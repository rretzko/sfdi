<div class="card">
                
    <div class="card-header" role="tab" id="parentheading">
        <h3>
            <a data-toggle="collapse" data-parent="accordion" 
               href="#parent" aria-expanded="true" 
               aria-controls="parent">Parent</a>
        </h3>
    </div><!-- card-header -->

    <div id="parent" class="collapse {{$nav_links['parent']}}" role="tabpanel"
         aria-labelledby="parentheading">
    
        <div class="card-block">
            
            <form class="bg-white text-dark" method="post" action="addParentForm">
                @csrf
            
                    <div class="container">

                    <fieldset class="form-group">

                        <!-- SCHOOLS TABLE -->
                        {!!$table_parents!!} 
                        
                        <!-- SUBMIT --> 
                        <div class="form-group d-flex flex-column">
                            <div class="form-row">
                                <div class="col">
                                   <button class="btn btn-primary" type="submit">Add Parent</button>
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

