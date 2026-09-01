<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">

  <title>Qcm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Materialize CSS -->
  <link href="{{ asset('app/bootstrap.min.css') }}" rel="stylesheet" >
  <link href="{{ asset('app/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('app/jquery-ui.css') }}" rel="stylesheet" >
  

  <link href="{{ asset('/fonts/font.css') }}" rel="stylesheet">

  <style>
    .full-button {
      width: 90%;
      margin: 0 auto;
      margin-top: 7px;
      display: block;
    }
    .logo {
      width: 90%;
      margin: 0 auto 20px;
      display: block;
    }
    .error-message {
      color: red;
      margin: 10px auto 0px;
      font-weight: bold;
      text-align: center;
    }
    .loading-spinner {
      display: none;
      position: absolute;
      right: 10px;
      top: 50%;
      transdiv: translateY(-50%);
    }
    .card-content div {
      margin: 25px;
    }
    
    .page {
      background-color: white;
    }
    .container {
      margin: 0px;
      padding: 0px;
      max-width: 100%;
    }
    .row {
      margin-left: 0px;
      margin-right: 0px;
    }
    .col-12 {
      padding: 0px;
    }
    .btn-choice {
      display: block;
      width: 95%;
      margin: 10px;
      text-align: start;
    }

    /* CSS */
    .button {
      align-items: center;
      appearance: none;
      background-color: #FCFCFD;
      border-radius: 4px;
      border-width: 0;
      box-shadow: rgba(45, 35, 66, 0.4) 0 2px 4px,rgba(45, 35, 66, 0.3) 0 7px 13px -3px,#D6D6E7 0 -3px 0 inset;
      box-sizing: border-box;
      color: #36395A;
      cursor: pointer;
      display: inline-flex;
      font-family: "JetBrains Mono",monospace;
      height: 48px;
      justify-content: center;
      line-height: 1;
      list-style: none;
      overflow: hidden;
      padding-left: 16px;
      padding-right: 16px;
      position: relative;
      text-align: left;
      text-decoration: none;
      transition: box-shadow .15s,transform .15s;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      white-space: nowrap;
      will-change: box-shadow,transform;
      font-size: 18px;
    }

    #test-div-page {
      padding: 20px;
      /*min-height: 700px;*/
    }

    .selected {
      background-color: #303f9f!important;
      color: white!important;
      font-weight: bold;
    }
    
    .btn.btn-outline-primary:hover {
      color: #0d6efd; /* Reset color on hover */
      background-color: initial; /* Reset background color on hover */
      border-color: #0d6efd; /* Reset border color on hover */
    }

    btn.btn-outline-primary:focus {
      border-color: #0d6efd; /* Reset border color on hover */
    }

    .navigation {
      text-align: center;
      margin-top: 25px;
    }

    .navigation button {
      width: 110px;
      height: 35px;
    }

    @media only screen and (max-width: 480px) {
      .navigation button {
        width: 70px;
        height: 50px;
      }
      .navigation button span{
        display: none;
      }
    }

    .question h5 {
      margin-top: 20px;
      margin-bottom: 30px;
    }

    .page-card {
      width: 50%;
      margin: auto;
    }

    @media screen and (min-width: 1024px) {
      .page-card {
        width: 35%;
        margin: auto;
      }
    }

    @media only screen and (max-width: 767px) {
      .page-card {
        width: 85%;
        margin-top: 30px !important;
      }
    }

    #finish-button {
      width: 100%;
      margin-top: 20px;
      display: none;
    }

    #timer {
      background-color: #000000;
      color: #81d830;
      text-align: center;
      font-size: 50px;
      line-height: 100%;
      width: 50%;
      margin: auto auto 22px;
      font-family: 'digifont';
    }
    
    #finish-div-page {
      padding-top: 50px;
      text-align: center;
      padding-bottom: 50px;
      /*min-height: 700px;*/
    }

    .finish-message {
      text-align: center;
      font-size: 25px;
      color: green;
      font-weight: bold;
      padding-top: 50px;
      padding-bottom: 50px;
    }

    .validation-error {
      border: 2px solid red;
    }

  </style>

</head>
<body style="background-color: #264c98" class="darken-4">

  <div class="container" style="">

    <div class="row">
      <div class="col-12">

        <div id="access-code-div-page" style="min-height: 400px;; margin-top: 100px;" class="card page-card">
          <div class="card-content">
              <div class="center-align">
                <img src="{{ asset('/images/logo-' . $id . '.png') }}" alt="Logo" class="logo">
              </div>

              <div>

                <div class="mb-3">
                  <label for="access-code" class="form-label">Access Code</label>
                  <input type="text" class="form-control" id="access-code" required>
                </div>
                
                <button id="auth-code-button" type="button" class="btn btn-primary full-button">
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  <span class="visually-hidden">Loading...</span>
                  Connexion
                </button>

                <button id="login-page-button" type="button" class="btn btn-primary full-button">
                  Login By Password
                </button>

                <div id="access-code-div-error-message" class="error-message"></div>
              </div>
          </div>
        </div>

        <div id="login-div-page" style="display: none; margin-top: 100px;" class="card page-card">
            <div class="card-content">

              <div class="center-align">
                <img src="{{ asset('images/logo-' . $id . '.png') }}" alt="Logo" class="logo">
              </div>

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" required value="">
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" required value="">
                </div>
                
                <button id="auth-login-button" type="button" class="btn btn-primary full-button">
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  <span class="visually-hidden">Loading...</span>
                  Connexion
                </button>

                <button id="code-page-button" type="button" class="btn btn-primary full-button">
                  Login By Code
                </button>

                <div id="login-div-error-message" class="error-message"></div>
            </div>        
        </div>

        <div id="data-div-page" style="display: none; margin-top: 30px" class="card page-card">
            <div class="card-content">

              <div class="center-align">
                <img src="{{ asset('images/logo-' . $id . '.png') }}" alt="Logo" class="logo">
              </div>

                <div class="mb-3">
                  <select class="form-control" id="test_id">                    
                  </select>
                </div>

                <div class="mb-3">
                  <input class="form-control" id="firstname" type="text" placeholder="First Name" required>
                </div>

                <div class="mb-3">
                  <input class="form-control" id="lastname" type="text" placeholder="Last Name" required>
                </div>

                <div class="mb-3">
                  <input class="form-control" id="phone" type="text" placeholder="Telephone"> 
                </div>

                <div class="mb-3">
                  <input class="form-control" id="email" type="email" placeholder="Email">
                </div>

                <div class="mb-3">
                  <input class="form-control" id="birthday" type="date" placeholder="Birthday" required type="text" onfocus="(this.type='date')" onblur="(this.value == '' ? this.type='text' : this.type='date')">
                </div>

                <!-- Submit Button -->
                <button id="start-button" type="button" class="btn btn-primary full-button">
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  <span class="visually-hidden">Loading...</span>
                  Start
                </button>

                <div id="data-div-error-message" class="error-message"></div>
              </div>
        </div>

        <div id="test-div-page" style="display: none;" class="page">

          <div id="timer" class="digifont">
            
          </div>

          <h2 id="question-count" style="font-weight: bolder;"></h2>

          <div id="questionContainer" class="question-container">

          </div>

          <div class="navigation">
                  <button id="firstBtn"><i class="fa-solid fa-backward-step"></i><span> First</span></button>
                  <button id="prevBtn"><i class="fa-solid fa-arrow-left"></i><span> Previous</span></button>
                  <button id="nextBtn"><i class="fa-solid fa-arrow-right"></i><span> Next</span></button>
                  <button id="lastBtn"><i class="fa-sharp fa-solid fa-forward-step"></i><span> Last</span></button>
          </div>
          <button id="finish-button" class="btn btn-danger" style="display:none">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span class="visually-hidden">Loading...</span>I Finished
          </button>
        </div>

        <div id="finish-div-page" style="display: none;" class="page">
          <div class="finish-message">ANSWERS HAVE BEEN SENT <br>GOOD LUCK</div> 
          
          <button class="btn btn-primary" id="restart">START NEW TEST</button>
        </div>    
      </div>
    </div>
  </div>

  <div id="errorDialog" title="Error">
    <p id="errorMessage"></p>
  </div>



  <script src="{{ asset('app/bootstrap.bundle.min.js') }}"></script>

  <script src="{{ asset('app/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('app/jquery-ui.min.js') }}"></script>

  <script>

    function setLoading(btn, bool){
      if(bool) {
        btn.prop('disabled', true);
        btn.find('.spinner-border').removeClass('d-none');
        btn.find('.visually-hidden').text('Loading...');
      } else {
        btn.prop('disabled', false);
        btn.find('.spinner-border').addClass('d-none');
        btn.find('.visually-hidden').text('');
      }
    }

    $(document).ready(function() {

      $('#errorDialog').dialog({
        autoOpen: false, // Start dialog as closed
        modal: true, // Modal dialog
        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
      });


      var host = "https://qcm.fsac.ma/api/";
      var studentTest = null;
      var user = null;

      var currentQuestionIndex = 0;
      var totalQuestions = 0;

      var counter = 0;

      var selectedChoiceBackground = '#269007';
      var unselectedChoiceBackground = '#FFFFFF';

      var timerRef = null;
      var timerRef2 = null;
      var counter = 0;


      function showQuestion(questionIndex) {
        $('[question]').hide();
        $('#'+questionIndex).show();
        updateNavigationButtons();
        $("#question-count").text("Question "+(currentQuestionIndex+1)+" of "+totalQuestions+" :");
      }

      function updateNavigationButtons() {
        $('#firstBtn').prop('disabled', currentQuestionIndex === 0);
        $('#prevBtn').prop('disabled', currentQuestionIndex === 0);
        $('#nextBtn').prop('disabled', currentQuestionIndex === totalQuestions - 1);
        $('#lastBtn').prop('disabled', currentQuestionIndex === totalQuestions - 1);
        if(currentQuestionIndex==totalQuestions - 1)
          $('#finish-button').show();
        else
          $('#finish-button').hide();
      }

      $('#firstBtn').click(function(evt) {
        evt.preventDefault();
        currentQuestionIndex = 0;
        showQuestion(currentQuestionIndex);
      });

      $('#prevBtn').click(function(evt) {
        evt.preventDefault();
        if (currentQuestionIndex > 0) {
          currentQuestionIndex--;
          showQuestion(currentQuestionIndex);
        }
      });

      $('#nextBtn').click(function(evt) {
        evt.preventDefault();
        if (currentQuestionIndex < totalQuestions - 1) {
          currentQuestionIndex++;
          showQuestion(currentQuestionIndex);
        }
      });

      $('#lastBtn').click(function(evt) {
        evt.preventDefault();
        currentQuestionIndex = totalQuestions - 1;
        showQuestion(currentQuestionIndex);
      });

      function ajaxCall(url, method, body, successCallback, errorCallback) {

        var options = {
          url: host + url,
          type: method,
          contentType: 'application/json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: body,
          success: function(data, status) {
            successCallback(data);
          },
          error: function(xhr, status, error) {
            //console.log(xhr, status, error);
            errorCallback(xhr.responseJSON);
          }
        };
        $.ajax(options);
      }

      function saveStudent(student, success, fail) {
        if(student.id=='') {
          ajaxCall('students_tests', 'GET', student,success, fail );
        } else {
          ajaxCall('students_tests/update/'+student.id, 'GET', student, success, fail);  
        }
      }

      function navigatePage(id){
        console.log(id);
        $('[id$="-page"]').hide();
        $('#'+id).show();
      }

      $('#login-page-button').click(function(event){
        event.preventDefault();
        navigatePage('login-div-page');
      });

      $('#code-page-button').click(function(event){
        event.preventDefault();
        navigatePage('access-code-div-page');
      });

      $('#auth-code-button').click(function(event){

        event.preventDefault();

        if(!checkEmptyFields(['access-code']))
          return false;


        var btn = $(this);
        setLoading(btn, true);

        ajaxCall('students_tests/access_code/'+$('#access-code').val().trim(), 'GET', null, function(resp) {
          studentTest = resp;
          console.log(studentTest.test.user.auto_step);
          ajaxCall('students_tests/tests/'+studentTest.test.user.id, 'GET', {}, function(tests){
            setLoading(btn, false);
            navigatePage('data-div-page');
            var select = $('#test_id');
            $.each(tests, function(index, obj) {
              select.append($('<option>').attr('value', obj.id).text(obj.name));
            });

            // FILL DATA 
            $('#firstname').val(studentTest.firstname);
            $('#lastname').val(studentTest.lastname);
            $('#test_id').val(studentTest.test_id);
            $('#phone').val(studentTest.phone);
            $('#email').val(studentTest.email);
            $('#birthday').val(studentTest.birthday);
          },function(error){
            $('#access-code-div-error-message').text(error).show();
          });
        }, function(error){
          console.log('here');
          console.log(error);
          setLoading(btn, false);
          $('#access-code-div-error-message').text(error).show();
        });

        return false;
      });

      $('#auth-login-button').click(function(event){

        event.preventDefault();

        if(!checkEmptyFields(['username','password']))
          return false;


        var btn = $(this);
        setLoading(btn, true);

        ajaxCall('auth/simplelogin', 'GET', {'username':$('#username').val().trim(), 'password':$('#password').val().trim()}, function(resp){
          user = resp;
          console.log(user);
          ajaxCall('students_tests/tests/'+user.id, 'GET', {}, function(tests){
            console.log(tests);
            var select = $('#test_id');
            $.each(tests, function(index, obj) {
              select.append($('<option>').attr('value', obj.id).text(obj.name));
            });
            setLoading(btn, false);
            navigatePage('data-div-page');
          },function(error){
            $('#login-div-error-message').text(error).show();
          });
        }, function(error){
          console.log(error);
          setLoading(btn, false);
          $('#login-div-error-message').text(error).show();
        });

        return false;
      });

      $('#start-button').click(function(event){
        event.preventDefault();

        if(!checkEmptyFields(['firstname','lastname','birthday']))
          return false;

        var btn = $(this);

        setLoading(btn, true);

        var student = {};
        student['id'] = (studentTest!=null)? studentTest.id : '';
        student['firstname'] = $('#firstname').val();
        student['lastname'] = $('#lastname').val();
        student['phone'] = $('#phone').val();
        student['email'] = $('#email').val();
        student['birthday'] = $('#birthday').val();
        student['test_id'] = $('#test_id').val();

        saveStudent(student, function(data) {
          setLoading(btn, false);

          studentTest = data;

          ajaxCall('students_tests/'+studentTest.id, 'GET', {}, function(data){
            studentTest = data;
            currentQuestionIndex = 0;
            console.log(data);
            try {
              for(let i=0; i<data.answers.length; i++){
                if(data.answers[i].selected_choice!=null){
                  currentQuestionIndex = i;
                }
              }
            } catch(ex){
              currentQuestionIndex = 0;
            }
            
            totalQuestions = studentTest.test.questions.length;
            counter = studentTest.test.duration - studentTest.consumed_time;
            startTimer();

            $('#questionContainer div').remove();

            $.each(studentTest.test.questions, function(index, question) {
              
              var $questionDiv = $('<div id="'+index+'" question="'+question.id+'" class="question">').html('<h5>' + question.question + '</h5>');

              $.each(question.choices, function(index, choice) {
                var $checkbox = $('<button class="btn btn-outline-primary btn-choice">').attr('choice_id', choice.id).attr('question_id', choice.question_id).text(choice.answer);
                if( question.answer != null && question.answer.choice_id==choice.id) {

                  $checkbox.addClass('selected');
                }
                $questionDiv.append($checkbox);
              });

              $('#questionContainer').append($questionDiv);
            });

            showQuestion(currentQuestionIndex);

            $('body').css('background-color', 'white');
            navigatePage('test-div-page');

          }, function(error){
            $("#data-div-error-message").val(error);
            setLoading(btn, false);
          });

        }, function(error){
          $("#data-div-error-message").val(error);
          setLoading(btn, false);
        });
        return false;
      });

      $('#finish-button').click(function(event){
        event.preventDefault();
        var btn = $(this);
        setLoading(btn, true);
        ajaxCall('finish', 'GET', {'student_test_id': studentTest.id}, function(){
          clearTimer();
          navigatePage('finish-div-page');
          setLoading(btn, false);
        }, function(){
          setLoading(btn, false);
        });
      });

      function selectChoice(questionIndex, question_id, choice_id, successCallback) {

        let answer = {'student_test_id' : studentTest.id, 'question_id' : parseInt(question_id), 'choice_id': parseInt(choice_id), 'consumed_time': studentTest.test.duration - counter};
        ajaxCall('answer', 'GET', answer, function(resp){
          //console.log(resp);
          successCallback();
        }, function(error){
          console.log(error);
        });
      }

      function handleFinishTest(){

        ajaxCall('finish', 'GET', {'student_test_id': studentTest.id}, function(){
          clearTimer();
          navigatePage('finish-div-page');
        }, function(){
        });

      }


      function startTimer(){

        // Clear any existing intervals first
        clearInterval(timerRef);
        clearInterval(timerRef2);

        timerRef = setInterval(() => {
          //console.log(counter);
          if(counter > 0){
            counter = counter - 1;
          }
          if(counter <= 60){
            closeFinish = true;
          }
          if(counter <= 0){
            handleFinishTest();
            clearTimer();
          }
          seconds =  Math.floor(counter % 60).toString().padStart(2, "0");
          minutes = Math.floor(counter / 60).toString().padStart(2, "0");
          $('#timer').html(minutes+'<span class="seperator">:</span>'+seconds+'<span class="seperator"></span>');
        }, 1000);

        timerRef2 = setInterval(() => {
          //console.log('timerRef2');
          ajaxCall('time', 'GET', {'consumed_time' : studentTest.test.duration - counter, 'student_test_id': studentTest.id}, function(){}, function(){});

        }, 5000);
      }

      function clearTimer() {
        counter = 0;
        clearInterval(timerRef);
        clearInterval(timerRef2);
      }

      $(document).on('click', '.btn-choice', function(evt) {
        var btn = $(this);
        btn.closest('.question').find('.btn-choice').removeClass('selected');
        btn.addClass('selected');
        selectChoice(currentQuestionIndex, $(this).attr('question_id'), $(this).attr('choice_id'), function(){
          // For auto step
          if(studentTest !=null && studentTest.test.user.auto_step==1){
            $('#nextBtn').click();
          }
        });
      });

      $('#restart').click(function(){
        location.reload();
      });


      function checkEmptyFields(ids) {
        let emptyFieldFound = false;
        let firstEmptyField = null;

        ids.forEach(id => {
            let element = document.getElementById(id);
            element.classList.remove('validation-error');
            if (!element.value.trim()) { // Check if value is empty or whitespace
                emptyFieldFound = true;
                if (!firstEmptyField) {
                    firstEmptyField = element;
                }
            }
        });

        if (emptyFieldFound) {
            // Show error dialog or message
            $('#errorMessage').text('Please fill in all required fields.'); // Set error message text
            $('#errorDialog').dialog('open'); // Open dialog

            // Put focus on the first empty field
            if (firstEmptyField) {
              firstEmptyField.classList.add('validation-error');
              //firstEmptyField.focus();
            }
            return false;
        }

        return true;
      }


    });
  </script>
</body>
</html>
