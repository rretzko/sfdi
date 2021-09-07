/*
 * teachersFromSchool.js
 * @since 2020.06.22
 */

var PATH = 'http://localhost/dev/sfdi/public/'; //https://studentfolder.info/';


function teachersFromSchool()
{console.log('@ teachersFromSchool');
    //advisories
    var advisory = 'If not listed above, please ask your teacher to sign up at <a href="https:\\TheDirectorsRoom.com" title="Sign up at TheDirectorsRoom.com" target="_blank" tabindex="-1">TheDirectorsRoom.com</a>.';
    var advisory_none = 'Please ask your teacher to sign up at <a href="https:\\TheDirectorsRoom.com" title="Sign up at TheDirectorsRoom.com" target="_blank" tabindex="-1">TheDirectorsRoom.com</a>.';

    //path
    if(location.hostname === 'localhost') {
        var $path = PATH+'TeachersFromSchool';
    }else{
        var $path = 'https://studentfolder.info/TeachersFromSchool';
    }

console.log('path: '+$path);
    //clear any existing messages
    $('.instructionTeacher').css('display', 'none');
//alert($path);
    $.ajax({
       method: 'POST',
       url: $path,
       data: {
           'school_id' : $('#id').val(),
            '_token' : $("input[name='_token']").val()
        },

       success: function(response){
console.log('35 success. ');
           var obj = JSON.parse(response); //create json object

           $('.teacherlist').html(obj);

           if(obj.length === 1){$('#customCheck0').attr('checked', true);}

           $('.instructionTeacher').html(obj.length ? advisory : advisory_none);

           $('.teacherlist').slideDown();

           $('.instructionTeacher').css('display', 'block');

       },
       error: function(jqXHR, textStatus, errorThrown){
//console.log('41. '+PATH+'TeachersFromSchool');
           console.log(JSON.stringify(jqXHR));
           console.log("AJAX error: "+textStatus+' : '+errorThrown);
       }
    });

}


