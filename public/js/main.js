/** global vars */

var PATH = '/dev/dStudentFolder/public/';

/*
 * primary js file for studentfolder.info
 * @author rick@mfrholdings.com
 * @since 2020.02.04
 */
$(document).ready(function()
{
    //set_Background_Image();

    //set focus
    if($('.school_add')){ //school_add view

        $('.school_id').focus();
    }

    if($('.parentguardian_add')){ //parentguardian_add view

        $('.parentguardiantype').focus();
    }

   $('.card-header')
        .bind('click',function(){
            collapse_Sections(this);
            remove_NavBar_Nav_Show();
            add_Show(section_Id($(this).attr('id')));
   });

   $('#mainNav .navbar-nav a')
        .bind('click', function(){
            console.log($(location).attr('href'));
            event.preventDefault();
            collapse_Sections(this);
            remove_NavBar_Nav_Show();
            add_Show(this);
            expand_Section($(this).attr('title'));
   });

   /**
    * Update teacher's checkbox selection(s) if school_id select box changes
    */
   $('.school_id').bind('change', function(){

       update_Teachers();
   });

   //Create teacher's checkbox selection(s) if a school_id is initialized
   //(old('id')
   if($('.school_id').val() > 0){

       update_Teachers();
   }

   /** Blank text-success field to remove artifact ex. Successful updates! */
   $('input').bind('blur', function(){

       $('.text-success').html('');
   });

   /** Toggle parent form between add and update */
   if(($('#parent_User_Id')) && ($('#parent_User_Id').val() > 0)){

       $('.parentguardian_add').attr('action','../student_Update_Parent');//http://localhost/dev/dStudentFolder/public/student_Update_Parent
   }

});

/**
 * Update navbar-nav based on user click in main content area
 *
 * @param show
 * @returns null
 */
function add_Show(show) //ex. event, profile, parent, etc
{
    $('.navbar-nav').children().each(function(){

        if(show === $(this).prop('title')){

            $(this).addClass('show');
        }
    });
}

function add_Show(obj)
{
    //remove active status from navbar-nav
    //remove_Active_Nav();

    //add active class to clicked object
    $(obj).addClass('show');


}

function checkbox_Bind_Click()
{
    $('input[type="checkbox"]').bind('click', function(){

       toggle_Submit_Button(check_Exists());
   });
}

function check_Exists()
{
    var exists = false;
    var advisory = 'visible';

    //look for a checked checkbox
    $('.form-check-input').each(function(){
        if( ($(this).is(':checked') === true)){

            exists = true;
            $('.advisory').css('visibility', 'hidden');
        }
    });

    if(exists){advisory = 'hidden';}
    $('.advisory').css('visibility', advisory);
    return exists;
}

/**
 * if user clicks on 'open' link, collapse the currently expanded section, else
 * if user clicks on 'closed' link, collapse all expanded links by
 * removing 'show' class
 *
 * @param obj //this of clicked card-header
 * @returns null
 */
function collapse_Sections(obj)
{
    var header_for = '';

    if($(obj).prop('title')){ //navBar-nav link is clicked

        header_for = ('#'+$(obj).prop('title'));

    }else{ //card-header is clicked

        var card_header = ($(obj).attr('id')); //ex. credentialsheading
        header_for = '#'+card_header.substring(0, (card_header.length - 7)); //remove "heading"
    }

    if($(header_for).attr('class') === 'collapse show'){

        $(obj).removeClass('show');
    }else{
        //remove all show classes from .card
        $('.card').children().each(function(){

           $(this).removeClass('show');
        });
    }

    return true;
}

/**
 * expand reference section by adding show class
 *
 * @param string section //ex. eventheading
 * @returns null
 */
function expand_Section(section)
{
    //collapse_Sections();

    //heading.len === 7
    var expand = '#'+section;

    //add show classes to
    $(expand).addClass('show');
 }

/**
 * Remove active class from navbar_nav
 *
 * @returns null
 */
function remove_NavBar_Nav_Show()
{
    $('.navbar-nav').children().each(function(){

        //clear active class whereever found
        $(this).removeClass('show');
    });
}

/**
 * remove all active classes from .navbar-nav
 * @returns null
 */
//function remove_Active_Nav()
//{
//    $('.navbar-nav').children().each(function(){

//        $(this).removeClass('active');
//    });
//}

/**
 * evaluate str and remove 'heading' if exists
 *
 * @param str
 * @return string
 */
function section_Id(str)
{
    var test = str.substring(0,(str.length - 7));

    return (test.length) ? test : str;
}

/**
 * Change background image with each page refresh
 */
function set_Background_Image()
{
    var urls = [
        //SAND
        'https://upload.wikimedia.org/wikipedia/commons/8/86/-%D8%AA%D9%8A%D9%86%D8%A7%D9%83%D8%A7%D8%B4%D8%A7%D9%83%D9%8A%D8%B1-_%D8%A7%D9%84%D8%AD%D8%B6%D9%8A%D8%B1%D8%A9_%D8%A7%D9%84%D9%88%D8%B7%D9%86%D9%8A%D8%A9_%D9%84%D8%B7%D8%A7%D8%B3%D9%8A%D9%84%D9%8A_%D8%A7%D9%84%D9%87%D9%82%D8%A7%D8%B1_-_%D8%AA%D8%A7%D9%85%D9%86%D8%B1%D8%A7%D8%B3%D8%AA_-_%D8%A7%D9%84%D8%AC%D8%B2%D8%A7%D8%A6%D8%B1.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:-%D8%AA%D9%8A%D9%86%D8%A7%D9%83%D8%A7%D8%B4%D8%A7%D9%83%D9%8A%D8%B1-_%D8%A7%D9%84%D8%AD%D8%B6%D9%8A%D8%B1%D8%A9_%D8%A7%D9%84%D9%88%D8%B7%D9%86%D9%8A%D8%A9_%D9%84%D8%B7%D8%A7%D8%B3%D9%8A%D9%84%D9%8A_%D8%A7%D9%84%D9%87%D9%82%D8%A7%D8%B1_-_%D8%AA%D8%A7%D9%85%D9%86%D8%B1%D8%A7%D8%B3%D8%AA_-_%D8%A7%D9%84%D8%AC%D8%B2%D8%A7%D8%A6%D8%B1.jpg" title="via Wikimedia Commons">Aboubakrhadnine</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //WATERFALL
        'https://upload.wikimedia.org/wikipedia/commons/b/bf/Ha_gorge.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:Ha_gorge.jpg" title="via Wikimedia Commons">Andloukakis</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //MEADOW
        'https://upload.wikimedia.org/wikipedia/commons/4/4d/%D0%A0%D0%BE%D0%B4%D0%BE%D0%B4%D0%B5%D0%BD%D0%B4%D1%80%D0%BE%D0%BD%D0%BD%D0%B8%D0%B9_%D1%81%D0%B2%D1%96%D1%82%D0%B0%D0%BD%D0%BE%D0%BA_%D0%BD%D0%B0_%D0%92%D1%83%D1%85%D0%B0%D1%82%D0%BE%D0%BC%D1%83_%D0%9A%D0%B0%D0%BC%D0%B5%D0%BD%D1%96.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:%D0%A0%D0%BE%D0%B4%D0%BE%D0%B4%D0%B5%D0%BD%D0%B4%D1%80%D0%BE%D0%BD%D0%BD%D0%B8%D0%B9_%D1%81%D0%B2%D1%96%D1%82%D0%B0%D0%BD%D0%BE%D0%BA_%D0%BD%D0%B0_%D0%92%D1%83%D1%85%D0%B0%D1%82%D0%BE%D0%BC%D1%83_%D0%9A%D0%B0%D0%BC%D0%B5%D0%BD%D1%96.jpg" title="via Wikimedia Commons">Misha Reme</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //MOUNTAIN TOP
        'https://upload.wikimedia.org/wikipedia/commons/a/a3/Crimea%2C_Ai-Petri%2C_low_clouds.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:Crimea,_Ai-Petri,_low_clouds.jpg" title="via Wikimedia Commons">Dmytro Balkhovitin</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //GLACIER
        'https://upload.wikimedia.org/wikipedia/commons/a/a3/Kayakistas_en_Glaciar_Grey.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:Kayakistas_en_Glaciar_Grey.jpg" title="via Wikimedia Commons">Pablo A. Cumillaf</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //CASCADING WATERFALL
        'https://upload.wikimedia.org/wikipedia/commons/0/0a/Mah_ya_waterfall_intranon.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:Mah_ya_waterfall_intranon.jpg" title="via Wikimedia Commons">BerryJ</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //HAYBALE
        'https://upload.wikimedia.org/wikipedia/commons/0/0f/In_Val_d%27Orcia.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:In_Val_d%27Orcia.jpg" title="via Wikimedia Commons">JP Vets</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //TREE STARS
        'https://upload.wikimedia.org/wikipedia/commons/4/46/%D0%9C%D0%BE%D0%B6%D0%B6%D0%B5%D0%B2%D0%B5%D0%BB%D0%BE%D0%B2%D0%B0%D1%8F_%D1%80%D0%BE%D1%89%D0%B0_%D0%B2_%D0%9D%D0%BE%D0%B2%D0%BE%D0%BC_%D0%A1%D0%B2%D0%B5%D1%82%D0%B5_%D0%BC%D1%8B%D1%81_%D0%9A%D0%B0%D0%BF%D1%87%D0%B8%D0%BA.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:%D0%9C%D0%BE%D0%B6%D0%B6%D0%B5%D0%B2%D0%B5%D0%BB%D0%BE%D0%B2%D0%B0%D1%8F_%D1%80%D0%BE%D1%89%D0%B0_%D0%B2_%D0%9D%D0%BE%D0%B2%D0%BE%D0%BC_%D0%A1%D0%B2%D0%B5%D1%82%D0%B5_%D0%BC%D1%8B%D1%81_%D0%9A%D0%B0%D0%BF%D1%87%D0%B8%D0%BA.jpg" title="via Wikimedia Commons">Войчук Владимир</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //BLUE WATER CAVE
        'https://upload.wikimedia.org/wikipedia/commons/b/bd/Blue_Water_Cave.jpg',
        //<a href="https://commons.wikimedia.org/wiki/File:Blue_Water_Cave.jpg" title="via Wikimedia Commons">Theglennpalacio</a> [<a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>]
        //CLOUDS
        //'images/shutterstock_471279443.jpg'
        'assets/images/cloud_pastel_web.png'

    ];

    //default
    //var url = 'images/shutterstock_471279443.jpg';
    var url = 'assets/images/cloud_pastel_web.png';

    var r = (Math.floor(Math.random() * 10));
    /** useful if count(urls) < 10 */
    if(r < urls.length){url = urls[r];} //use targeted urls
    document.body.style.backgroundImage = "url('"+url+"')";
}

function toggle_Submit_Button(check_exists)
{
    //if at least one checkbox is checked, enable button, else disable
    if(check_exists){
        $('.btn-primary')
            .prop('disabled', false)
            .html('Add');
    }else{

        $('.btn-primary')
            .prop('disabled', true)
            .html('Select a Teacher');
    }
}

function update_Teachers()
{
    //clear any existing messages
    $('.help').html('');

    $.ajax({
       method: 'POST',
       url: PATH+'student/ajaxupdate',
       data: {
           'school_id' : $('.school_id').val(),
            '_token' : $("input[name='_token']").val()
        },
       success: function(response){

           var obj = JSON.parse(response); //create json object

           $('.custom-checkbox')
                   .html(obj.test)
                   .removeClass('d-none');

           checkbox_Bind_Click();

           toggle_Submit_Button(check_Exists());

       },
       error: function(jqXHR, textStatus, errorThrown){
           console.log(JSON.stringify(jqXHR));
           console.log("AJAX error: "+textStatus+' : '+errorThrown);
       }
    });
}

