var PATH = '/public/';

function XstudentDuplicate()
{
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();

    if(first_name && last_name && email) {
        $.ajax({
            method: 'POST',
            url: PATH+'DuplicateStudentRegistrationCheck',
            data: {
                'email' : email,
                'first_name' : first_name,
                'last_name' : last_name,
                '_token' : $("input[name='_token']").val()
            },

            success: function(response){
console.log(22);
console.log('duplicate: '+response.duplicate);

            },
            error: function(jqXHR, textStatus, errorThrown){
//console.log('41. '+PATH+'TeachersFromSchool');
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: "+textStatus+' : '+errorThrown);
            }
        });
    }
}
