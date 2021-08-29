/*
 * Copyright (C) 2020 Fredric Retzko <rick@mfrholdings.com at MFR Holdings, LLC>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/** global vars */
var PATH = '/public/';
var AJAXRESPONSE = '';

$(document).ready(function()
{
    /* update alert icon */
    updateAlertIcon();

    /*hide/display forms */
    $('#show_Add_Edit_Form').bind('click', function(){

        $('.add_form').slideToggle();
        $('#name').focus();
    });

    /*hide/display forms */
    //if($('.add_form.edit').length){
    if($('#name') && $('#name').val()){

        $('.add_form').slideToggle();

        $('#name').focus();
    }

    if($('.pending_link')){

        $('.pending_link').on('click', function(){

            toggle_Checkboxes(this)
        });
    }

    /*display names of schools matching partial input*/
    if($('.js_school_names')){

        $('#name').bind('keyup', function(){

            getSchoolNames(getSchoolNamesPrint);

        });
    }

    //ensure only options > start_year are available for end_year selection
    if($('#start_Year')){

        $('#start_Year').bind('change', function(){

           var start_year = $('#start_Year option:selected').val();

           $('#end_Year option').filter(function(){
                if(parseInt(this.value) > 0){ //do not remove 'Last Year' option
                                              //otherwise all employment will
                                              //require an ending year
                    return parseInt(this.value) < start_year;
                }
           }).remove();

        });
    }

    //ensure that a start year is selected BEFORE allowing end year selection
    if($('#end_Year')){

        $('#end_Year').bind('change', function(){

            if($('#start_Year').val() === '0'){

                $('#start_Year').focus();
                $('#end_Year option:eq(0)').prop('selected', true);
                alert('You must select a First Year before selecting a Last Year.');
            }
        });
    }

    /*display warning/confirmation on user delete school action */
    if($('.school_delete').length){

        $('.school_delete a').bind('click', function(){

           var mssg = 'Deleting '+$('#name').val()+' from this list will also ';
           mssg += 'detach the links for students, ensembles, music library ';
           mssg += 'and programs.\n\n ';
           mssg += 'Click "OK" to delete '+$('#name').val()+' from this list.\n';
           mssg += 'Otherwise, click "Cancel".';

           if(!confirm(mssg)){

                event.preventDefault();
                console.log(81);
            }

        });
    }

    /*display instructions on click if js_instructions exists*/
    if($('.js_instructions').length){

        $('.js_instructions_link').bind('click', function (){

            displayInstructions();
        });
    }

    /*display school_id and instructions for student upload*/
    if($('.js_school_id').length){

        //use the first option as the initial value
        $('.js_school_id').html('Use <b>'+$('.js_school_id_link option:first').val()+'</b> for your school_id value.');

        $('.js_school_id_link').bind('change', function(){

            $('.js_school_id').html('Use <b>'+$('.js_school_id_link').val()+'</b> for your school_id value.');
        });
    }

    /* make table column headers sortable */
    if($('#roster').length){

        $('#roster').DataTable();
        $('.dataTables_length').addClass('bs-select');
    }

    /* workaround to fix problem with navMenu dropdown dieing after first click */
    $(".dropdown-toggle").dropdown();

    /* toggle video status: approved/null */
    if($('.approved')){

        $('.approved').bind('click', function(){

            toggle_Video_Approval(this);
        });
    };

    /* chicken test for removing a video (used on TheDirectorsRoom.com)*/
    if($('.rejected')){

        $('.rejected').bind('click', function(){

            if(chickenTest_RejectVideo(this, event)){

                reject_Video(this);
            }

        });
    };

    /* chicken test for removing a video (used on StudentFolder.info)*/
    if($('.remove')){

        $('.remove').bind('click', function(){

            if(chickenTest_RemoveVideo(this, event)){

                remove_Video(this);
            }

        });
    };

    /* for register functions */
    if($('#email')){

        $('#email').bind('blur', function(){
            studentDuplicate();
        });

        $('#first_name').bind('blur',function(){
            studentDuplicate();
        });

        $('#last_name').bind('blur', function(){
            studentDuplicate();
        });

    }


});

function calculate_Age()
{
    var birthyear = $('#birthday').val().substring(0,4);
    var d = new Date();
    var curyear = d.getFullYear();
    var age = (parseInt(curyear) - parseInt(birthyear));

    return $('.calculated_age').html(age+' years');
}

function calculate_Height()
{
    var height = $('#height').val();

    var feet = parseInt(parseInt(height) / 12);
    var inches = parseInt(parseInt(height) % 12);

    return $('.calculated_height').html(feet+"' "+inches+'"');
}

function chickenTest(obj, event, mssg)
{
    event.preventDefault();

    return confirm(mssg);
}

function chickenTest_RejectVideo(obj, event)
{
    event.preventDefault();

    var mssg = 'Click "OK" to reject this video.\n'
    + 'If an email is available, the student will be advised to submit a new video.\n'
    + 'Otherwise, please click "Cancel".';

    return confirm(mssg);
}

function chickenTest_RemoveVideo(obj, event)
{
    var mssg = 'Click "OK" to remove this video.';

    return chickenTest(obj, event, mssg);
}

function displayInstructions()
{
    $('.js_instructions').slideToggle();
}

function findSchool(school_id)
{
    var data = {
            '_token': $("input[name='_token']").val(),
            'school_id': school_id
            };

    var url = PATH+'ajaxSchool';

    runAjax(url, data, populateSchoolForm);
}

function getSchoolNames(callback)
{
    var data = {
            'partial': $('#name').val()
            };

    var url = PATH+'ajaxSchools';

    runAjax(url, data, callback);
}

function getSchoolNamesPrint()
{
    $('.js_school_names').html(AJAXRESPONSE.schools);
}

function locationReload()
{
    location.reload();
}

function logPaypalPayment(vendor_id, amount, auditionnumber)
{
    var data = {
        '_token': $("input[name='_token']").val(),
        'vendor_id': vendor_id,
        'amount': amount,
        'auditionnumber': auditionnumber,
    };

    var url = PATH+'AjaxLogStudentPayment';

    runAjax(url, data, updateInvoiceTable);
};

function permissionToRemove()
{
    if(AJAXRESPONSE.res === 'denied'){

        alert('This video has been approved by your teacher and cannot be removed.');
    }else{

        locationReload();
    }
}

function populateSchoolForm()
{
    //remove any artifacts
    populateSchoolFormClear();

    //populate form with new values
    $('#name').val(AJAXRESPONSE.name);
    $('#address_01').val(AJAXRESPONSE.address_01);
    $('#address_02').val(AJAXRESPONSE.address_02);
    $('#city').val(AJAXRESPONSE.city);
    $('#geo_State_Id option[value="'+AJAXRESPONSE.geo_state_id+'"]').prop('selected', true);
    $('#postal_Code').val(AJAXRESPONSE.postal_code);
    updateGradeCheckboxes();

    $('.js_school_names').html('');
}

function populateSchoolFormClear()
{
    $('#name').val('');
    $('#address_01').val('');
    $('#address_02').val('');
    $('#city').val('');
    $('#geo_State_Id option[value="0"]').prop('selected', true);
    $('#postal_Code').val('');
    $('input[type="checkbox"]').prop('checked', false);
}

function rejectStudentFromRoster(teacher_id, student_id)
{
    var data = {
            '_token': $("input[name='_token']").val(),
            'teacher_id': teacher_id,
            'student_id': student_id,
            };

    var url = PATH+'AjaxRejectStudentFromRoster';

    runAjax(url, data, locationReload);
}

/** @todo work through text and process for rejection */
function reject_Video(obj)
{
    var data = {
        '_token': $("input[name='_token']").val(),
        'server_id': $(obj).attr('server_id')
    };

    var url = PATH+'AjaxVideoRejection';

    /** @todo work through text and process for rejection */
    runAjax(url, data, locationReload);
}

/** @todo work through text and process for rejection */
function remove_Video(obj)
{
    var data = {
        '_token': $("input[name='_token']").val(),
        'server_id': $(obj).attr('server_id')
    };

    var url = PATH+'AjaxVideoRemoval';

    /** @todo work through text and process for rejection */
    runAjax(url, data, permissionToRemove);
}

function replaceAlertIcon()
{
    $('.alerticon').html(AJAXRESPONSE['res']);
}

function runAjax(url, data, callback)
{
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $("input[name='_token']").val()}
    });

    $.ajax({
        type:'POST',
        url: url,
        data: data,

        success:function(response){

            AJAXRESPONSE = response;

           //allow for no-callback option
           if(callback){
//console.log(callback);
                callback();
            }
        },

        error: function(jqXHR, textStatus, errorThrown){

           return false;
       }

    });
}

function haltRegistration()
{console.log(AJAXRESPONSE);
    var obj = $.parseJSON(AJAXRESPONSE);
    console.log('res: '+obj.res);
    console.log('people: '+obj.people);
    if(obj.res){
        console.log('removing class');
        $('.advisory').removeClass('d-none');
        $('#register_btn').css({
            'display':'none',
            'visibility':'hidden',
        });
    }else{
        $('.advisory').addClass('d-none');
        $('#register_btn').css({
            'display':'block',
            'visibility':'visible',
        });
    }
}

function studentDuplicate()
{
    if($('#first_name').length && $('#first_name').val().length &&
        $('#last_name').length && $('#last_name').val().length &&
        $('#email').length && $('#email').val().length) {

        var url = PATH + 'DuplicateStudentRegistrationCheck';
        var data = {
            '_token': $("input[name='_token']").val(),
            'email': $('#email').val(),
            'first_name': $('#first_name').val(),
            'last_name': $('#last_name').val(),
        };

        runAjax(url, data, haltRegistration);
    }
    /*
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

     */
}

function student_Accept(teacher_id, student_id)
{
    updateStudentStatus(teacher_id, student_id, 'accepted');
}

function student_Reject(teacher_id, student_id)
{
    rejectStudentFromRoster(teacher_id, student_id);
}

function toggle_Checkboxes(obj)
{
    var target = '#'+$(obj).attr('div_child');

    $(target).toggle(300);
}

function toggle_Video_Approval(obj)
{
    if(obj.id){

        var data = {
            '_token': $("input[name='_token']").val(),
            'videotype_id': obj.id, //approved_###
            'server_id': $(obj).attr('server_id')
        };

        var url = PATH+'AjaxVideoApproval';

        runAjax(url, data, false);
    }

}

function updateAlertIcon()
{
    //csrf token MUST be on the page for the alert icon to activate
    if($("input[name='_token']").val()){

        var data = {
            '_token': $("input[name='_token']").val(),
        };

        var url = PATH+'AjaxAlertIcon';

        runAjax(url, data, replaceAlertIcon);
    }
}

function updateGradeCheckboxes()
{
    if(AJAXRESPONSE.grades.length){

        var grades = AJAXRESPONSE.grades.split(',');

        grades.forEach(function(item, index){
            var chbx = '#grade_'+item;

            $(chbx).prop('checked', true);
        })

    }
}

function updateInvoiceTable()
{
    $('#invoice').html(AJAXRESPONSE.invoice);
}

function updateStudentStatus(teacher_id, student_id, status)
{
    var data = {
            '_token': $("input[name='_token']").val(),
            'teacher_id': teacher_id,
            'student_id': student_id,
            'descr': status,
            };

    var url = PATH+'AjaxUpdateStudentStatus';

    runAjax(url, data, locationReload);
}
