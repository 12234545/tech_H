@extends('welcome')

@section('title', 'singUp')

@section('content')
<div class="container4">
<div class="form-container">
    <h1>Sing Up</h1>
        <div class="progress-bar">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
            <div class="progress-step">5</div>

        </div>

        <form id="signupForm"  action="{{ route('register') }}" method="POST" >
            @csrf
            <div class="step active" data-step="1">
                <div class="form-group">

                    <input type="text" id="firstname" name="firstname" placeholder="firstname" required>
                    <small id="firstnameError"></small>
                </div>
                <div class="form-group">

                    <input type="text" id="lastname" name="lastname" placeholder="lastname" required>
                    <small id="lastnameError"></small>
                </div>

                <div class="buttons">
                    <div></div>
                    <button class="next" id="final"  onclick="nextStep(1)">Next</button>
                </div>
            </div>


            <div class="step" data-step="2">
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <small id="emailError"></small>
                </div>
                <div class="buttons">
                    <button class="prev" onclick="prevStep(2)">Old</button>
                    <button class="next" id="final" onclick="nextStep(2)">Next</button>
                </div>
            </div>

         <div class="step" data-step="3">
                <div class="form-group">
                    <textarea id="description" name="description" rows="5" cols="40" placeholder="Entrez une description  ici..." required></textarea>
                </div>
                <div class="buttons">
                    <button class="prev" onclick="prevStep(3)">Old</button>
                    <button class="next" id="final"  onclick="nextStep(3)">Next</button>
                </div>
            </div>
          <div class="step" data-step="4">
                <div class="profile-upload">
                    <div class="profile-preview empty" id="preview"></div>
                    <input type="file" id="profile-photo" name="profile-photo" accept="image/*">
                    <label for="profile-photo" class="upload-btn">choose a photo</label>
                </div>
                <div class="buttons">
                    <button class="prev" onclick="prevStep(4)">Old</button>
                    <button class="next" id="final"  onclick="nextStep(4)">Next</button>
                </div>
            </div>
            <script >document.getElementById('profile-photo').addEventListener('change', function(e) {
                const preview = document.getElementById('preview');
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Photo de profil">`;
                        preview.classList.remove('empty');
                    }

                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = '';
                    preview.classList.add('empty');
                }
            });</script>
            <div class="step" data-step="5">
                <div class="form-group">
                    <label for="password">Password </label>
                    <input type="password" id="password" name="password" required>
                    <small id="passwordError"></small>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="buttons">
                    <button class="prev" onclick="prevStep(5)">Old</button>
                    <button class="next " id="final"  onclick="submitForm()">Submit</button>
                </div>

            </div>
            <div class="success-overlay" id="successOverlay">
                <div class="success-checkmark" id="successCheckmark">
                    <div class="check-icon"></div>
                </div>
                <div class="success-text" id="successText">
                    Registration Successful !
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
