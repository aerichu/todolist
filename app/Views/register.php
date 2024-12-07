<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="mt-5 mb-5 login-input" action="<?=base_url('home/aksi_t_register')?>" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="yourUsername" class="form-label">Username</label>
                    <input type="text" class="form-control form-control-user" id="exampleFirstName"
                    placeholder="Your name" name="nama">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="yourUsername" class="form-label">Password</label>
                    <input type="password" class="form-control form-control-user"
                    id="exampleInputPassword" placeholder="Password" name="pass">
                  </div>
                </div>
                <button class="btn btn-primary">Create an account</button>

              </form>
              <hr>

              <div class="text-center">
                <a class="small" href="http://localhost:8080/home/login">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>