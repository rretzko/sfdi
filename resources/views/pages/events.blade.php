@extends('layouts.page')

@section('title')
Events
@endsection

@section('content')
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="page-title m-0">
                                    Events
                                </h1>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="datatable-container eventspage">
                                {!!$table_events!!} 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
@endsection


@section('pagescripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    var eventsTable = $('#datatable').DataTable({
        "order": [],
        dom: '<"row"<"col"l><"col text-right"<"#showMyEventsCheckBox">>>t<"row"<"col"i><"col"pr>>',
        fnInitComplete: function(){
            $('div#showMyEventsCheckBox').html('<input type="checkbox" name="showMyEvents" id="showMyEvents"><label for="showMyEvents">Show My Events</label>');
        }
    });
    $('#showMyEvents').on('change', function() {
        if ($(this).is(':checked')) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {  
                    return $(eventsTable.row(dataIndex).node()).hasClass('myEvent');
                }
            )
        } else {
            $.fn.dataTable.ext.search.pop()
        }
        eventsTable.draw()
    })
});
</script>
@endsection