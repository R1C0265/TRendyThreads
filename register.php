<?php
require_once 'partials/header.php';
?>
<main class="main">
  <section class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow">
            <div class="card-body p-5">
              <div class="text-center mb-4">
                <h2>Create Account</h2>
                <p class="text-muted">Join Trendy Threads today!</p>
              </div>
              
              <form id="registerForm">
                <div class="mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="u_name" class="form-control" required>
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="u_email" class="form-control" required>
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Phone</label>
                  <input type="tel" name="u_phone" class="form-control">
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Address</label>
                  <textarea name="u_address" class="form-control" rows="2"></textarea>
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="u_password" class="form-control" minlength="6" required>
                </div>
                
                <div class="mb-4">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">
                      I agree to the Terms & Conditions
                    </label>
                  </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100" id="registerBtn">
                  Create Account
                </button>
              </form>
              
              <div class="text-center mt-4">
                <p>Already have an account? <a href="signin.php">Sign In</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
  $('#registerForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
      url: 'model/addUser.php',
      type: 'POST',
      data: $(this).serialize(),
      beforeSend: function() {
        $('#registerBtn').prop('disabled', true).text('Creating Account...');
      },
      success: function(response) {
        console.log('Server response:', response);
        if (response == '1') {
          alert('Account created successfully!');
          window.location.href = 'signin.php';
        } else if (response == '3') {
          alert('Email already exists!');
        } else if (response == '4') {
          alert('Please fill in all required fields.');
        } else if (response == '0') {
          alert('Invalid request. Please try again.');
        } else {
          alert('Error creating account. Server response: ' + response);
        }
      },
      error: function() {
        alert('Network error. Please try again.');
      },
      complete: function() {
        $('#registerBtn').prop('disabled', false).text('Create Account');
      }
    });
  });
});
</script>

<?php require_once 'partials/footer.php'; ?>