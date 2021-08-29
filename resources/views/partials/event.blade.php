<div class="card">
                
    <div class="card-header" role="tab" id="eventheading">
        <h3>
            <a data-toggle="collapse" data-parent="accordion" 
               href="#event" aria-expanded="true" 
               aria-controls="event">Event</a>
        </h3>
    </div><!-- card-header --> 

    <div id="event" class="collapse {{$nav_links['event']}}" role="tabpanel"
         aria-labelledby="eventheading">
        <div class="card-block">Event Form</div>
        
        <div class="container">
            
            <!-- EVENTS TABLE -->
            {!!$table_events!!} 
            
        </div>

    </div>

</div><!-- card -->

