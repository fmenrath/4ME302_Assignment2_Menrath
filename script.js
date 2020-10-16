$(document).ready(function() {
    //------------- Page Height ----------------
    $('.content-container').css("min-height", function(){ 
        return $(this).height($(window).height() - $('.header').height() - $('#nav-bar').height() - 52);
    });

    //------------- Login Menu -------------
    //Patient-Login
    $("#btn-patient").click(function(){
        $(".btn-card-content").fadeOut(150, function(){
            $("#note-small").hide();
            $("#note").text("Sign in as a patient");
            $(".btn-group").html('<a href="login.php?provider=google" class="btn-google"><i class="fab fa-google" aria-hidden="true"></i>&nbsp;Login with Google</a><p class="question">Not a patient? <a href="">Go back</a></p>');;
            $(".btn-card-content").fadeIn(150);
        });
    });
    
    //Physican-Login
    $("#btn-physician").click(function(){
        $(".btn-card-content").fadeOut(150, function(){
            $("#note-small").hide();
            $("#note").text("Sign in as a physician");
            $(".btn-group").html('<a href="login.php?provider=twitter" class="btn-twitter"><i class="fab fa-twitter" aria-hidden="true"></i>&nbsp;Login with Twitter</a><p class="question">Not a physician? <a href="">Go back</a></p>');;
            $(".btn-card-content").fadeIn(150);
        });    
    });

    //Researcher-Login
    $("#btn-researcher").click(function(){
        $(".btn-card-content").fadeOut(150, function(){
            $("#note-small").hide();
            $("#note").text("Sign in as a researcher");
            $(".btn-group").html('<a href="login.php?provider=github" class="btn-github"><i class="fab fa-github" aria-hidden="true"></i>&nbsp;Login with Github</a><p class="question">Not a researcher? <a href="">Go back</a></p>');;
            $(".btn-card-content").fadeIn(150);
        });   
    });

    //------------- Load default content -------------
    if($("#nav-patients-researcher").hasClass('nav-active')){
        $(".content-container").load('includes/content/content_researcher.php');
    }
    if($("#nav-patients-physician").hasClass('nav-active')){
        $(".content-container").load('includes/content/content_physician.php');
    }
    if($("#nav-videos").hasClass('nav-active')){
        $(".content-container").load('includes/content/videos.php');
    }

    //------------- Navbar Content Switch -------------
    //RSS feed button
    $("#nav-rss-news").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/rss_feed.php');
    });
    // Profile page button
    $("#nav-profile").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/profile.php');
    });
    // Patients (Researcher) page button
    $("#nav-patients-researcher").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/content_researcher.php');
    });
    // Patients (Physician) page button
    $("#nav-patients-physician").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/content_physician.php');
    });
    // Patient data button
    $("#nav-data").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/content_patient.php'); 
    });
    // Patient videos button
    $("#nav-videos").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/videos.php');
    });


    //--------------- Modal Windows -----------------
    // Open Modal window for CSV files
    $(document).on('click', '.btn-data-view', function(){
        //Get filename for heading of modal window
        $filename = $(this).siblings('.data-select').val();
        $('#data-modal').fadeIn(200);
        $('#data-modal').load('includes/content/modal/modal_csv.php?filename='+$filename);
    });

    // Open Modal window for Therapy/Test Session Info (Physician) --> Show only his patients
    $(document).on('click', '.btn-therapy-view', function(){
        $patient = $(this).val();
        $('#data-modal').fadeIn(200);
        $('#data-modal').load('includes/content/modal/modal_therapy.php?patient='+$patient);
    });

    // Open Modal window for Therapy/Test Session Info (Researcher) --> Show all patients from the hospital
    $(document).on('click', '.btn-therapy-researcher-view', function(){
        $patient = $(this).val();
        $('#data-modal').fadeIn(200);
        $('#data-modal').load('includes/content/modal/modal_therapy_researcher.php?patient='+$patient);
      });

    // Close Modal window
    $(document).on('click', '#modal-close', function(){
        $('#data-modal').fadeOut(200);
    });

    //--------------- Download the CSV file -----------------
    $(document).on('click', '.btn-data-download', function(e){
        e.preventDefault();
        window.location.href = $(this).siblings('.data-select').val();
    });
});

