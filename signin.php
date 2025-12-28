<?php
require_once 'partials/header.php';
?>

<main class="main">
  <!-- Sign In Section -->
  <section class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card shadow">
            <div class="card-body p-5">
              <div class="text-center mb-4">
                <h2>Welcome back!</h2>
                <p class="text-muted">Happy to see you again!</p>
              </div>
              
              <form class="pt-3" id="login">
                <div class="form-group mb-3">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-envelope"></i>
                    </span>
                    <input
                      type="email"
                      name="email"
                      required
                      class="form-control form-control-lg"
                      id="exampleInputEmail"
                      placeholder="Your Email" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-lock"></i>
                    </span>
                    <input
                      type="password"
                      name="password"
                      required
                      class="form-control form-control-lg"
                      id="exampleInputPassword"
                      placeholder="Your Password" />
                  </div>
                </div>
                <div
                  class="my-3 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="keepSignedIn" />
                    <label class="form-check-label" for="keepSignedIn">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="text-primary">Forgot password?</a>
                </div>
                <div class="my-3">
                  <button
                    id="btnSub"
                    type="submit"
                    class="btn btn-primary w-100 btn-lg">
                    LOGIN
                  </button>
                </div>
                <div class="text-center mt-4">
                  Don't have an account?
                  <a href="register.php" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  $("#login").submit(function(e) {
    e.preventDefault();

    $.ajax({
      url: "model/login.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $("#btnSub").addClass("disabled");
        $("#btnSub").html("Processing");
      },
      success: function(data) {
        console.log(data);
        //Admin Login
        if (data == 1) {
          window.location.href = "admin/index.php";
        } else if (data == 2) {
          //employee login
          window.location.href = "employee/index.php";
        } else if (data == 3) {
          //customer login
          window.location.href = "index.php";
        } else {
          // show server response for debugging
          alert("Login failed. Server returned: " + data);
        }
        $("#btnSub").removeClass("disabled");
        $("#btnSub").html("LOGIN");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(
          "AJAX error:",
          textStatus,
          errorThrown,
          "response:",
          jqXHR.responseText
        );
        alert(
          "Request failed: " + textStatus + " — see console for details."
        );
        $("#btnSub").prop("disabled", false).text("LOGIN");
      },
    });
  });
</script>

<?php require_once 'partials/footer.php'; ?>