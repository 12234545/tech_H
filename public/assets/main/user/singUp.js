
function hh() {

    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm-password').val();
    var passwordLength = password.length;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    var firstnameRegex = /^[a-zA-Z]+$/;


    if(firstname != "" && /^[a-zA-Z]+$/.test(firstname)){
     $('#firstname').css('border-color','green');
     $('#firstnameError').text('');


         if(lastname != "" && /^[a-zA-Z]+$/.test(lastname)){

             $('#lastname').css('border-color','green');
             $('#lastnameError').text('');


             if(email != "" && emailRegex.test(email)){
                 $('#email').css('border-color','green');
                 $('#emailError').text('');

                 if(password != "" && passwordRegex.test(password) && passwordLength >= 8){
                     $('#password').css('border-color','green');
                     $('#passwordError').text('');

                     if(confirmPassword != "" && confirmPassword == password){
                         $('#confirm-password').css('border-color','green');
                         $('#confirmPasswordError').text('');

                         $('signupForm').submit();

                     }else{
                         $('#confirm-password').css('border-color','red');
                         $('#confirmPasswordError').text('Your password is not valid');
                     }

                 }else{
                     $('#password').css('border-color','red');
                     $('#passwordError').text('Your password is not valid');
                 }
             }else{
                 $('#email').css('border-color','red');
                 $('#emailError').text('Your email is not valid');
             }

         }else{
             $('#lastname').css('border-color','red');
             $('#lastnameError').text('Your lastname is not valid');
         }

    }else{

     $('#firstname').css('border-color','red');
     $('#firstnameError').text('Your firstname is not valid');
    }


 };


 function nextStep(currentStep) {

    const currentStepElement = document.querySelector(`.step[data-step="${currentStep}"]`);
    const inputs = currentStepElement.querySelectorAll('input');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value) {
            isValid = false;
            input.style.borderColor = 'red';
        } else {
            input.style.borderColor = '#ddd';
        }
    });

    if (!isValid) return;


    currentStepElement.classList.remove('active');
    const nextStepElement = document.querySelector(`.step[data-step="${currentStep + 1}"]`);
    nextStepElement.classList.add('active');


    document.querySelector(`.progress-step:nth-child(${currentStep + 1})`).classList.add('active');
}

function prevStep(currentStep) {

    const currentStepElement = document.querySelector(`.step[data-step="${currentStep}"]`);
    currentStepElement.classList.remove('active');
    const prevStepElement = document.querySelector(`.step[data-step="${currentStep - 1}"]`);
    prevStepElement.classList.add('active');


    document.querySelector(`.progress-step:nth-child(${currentStep})`).classList.remove('active');
}

function showSuccessMessage() {
    const overlay = document.getElementById('successOverlay');
    const checkmark = document.getElementById('successCheckmark');
    const text = document.getElementById('successText');


    overlay.classList.add('active');
    overlay.classList.add('fade-in');


    setTimeout(() => {
        checkmark.classList.add('active');
    }, 200);


    setTimeout(() => {
        text.classList.add('active');
    }, 1000);



}


function submitForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        return;
    }

    if (password == confirmPassword){
    showSuccessMessage();
    }
}


