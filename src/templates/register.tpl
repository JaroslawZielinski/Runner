{extends file="{$homepage}"}

{block name=head}
    <script src="/js/form.utils.js" type="text/javascript"></script>
{/block}

{block name=content}
    <div class="runner">
        <h1>Register form</h1>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form id="register" action="{$backendPath}" class="form-horizontal" method="POST" role="form" novalidate autocomplete="off">
                <input name="csrf-token" type="hidden" value="{$csrfToken}">

                <div class="form-group" style="position: static;">
                    <label for="first_name">First Name</label>
                    <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter First Name" autocomplete="off" required>
                    <p class="help-block"></p>
                </div>

                <div class="form-group" style="position: static;">
                    <label for="last_name">Last Name</label>
                    <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter Last Name" autocomplete="off" required>
                    <p class="help-block"></p>
                </div>

                <div class="form-group" style="position: static;">
                    <label for="email">E-mail</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Enter E-mail" autocomplete="off" required>
                    <p class="help-block"></p>
                </div>

                <div class="form-group" style="position: static;">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option disabled value="" selected hidden>Enter Gender</option>
                        <option value="male">boys</option>
                        <option value="female">girls</option>
                    </select>
                    <p class="help-block"></p>
                </div>

                <div class="form-group" style="position: static;">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" autocomplete="off" required>
                    <p class="help-block"></p>
                    <p class="help-block">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</p>
                </div>

                <div class="form-group" style="position: static;">
                    <label for="password2">Confirm password</label>
                    <input id="password2" name="password2" type="password" class="form-control" placeholder="Password" autocomplete="off" required>
                    <p class="help-block"></p>
                </div>

                <div class="form-group" style="padding-right: 20px; position: static;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
    <script type="text/javascript">
        jQuery(function() {
            jQuery("form#register").on('submit', function() {
                var validation = true;

                var FirstName = jQuery("input#first_name").val();
                var LastName = jQuery("input#last_name").val();
                var Email = jQuery("input#email").val();
                var Gender = jQuery("select#gender").val();
                var Password = jQuery("input#password").val();
                var Password2 = jQuery("input#password2").val();

                if (FirstName.trim() == "") {
                    showValidationError("first_name", "Given name \"" + FirstName + "\" length is not acceptable!");
                    disproveCorectness("first_name");
                    validation = false;
                } else {
                    hideValidationErorr("first_name");
                    aproveCorectness("first_name");
                }

                if (LastName.trim() == "") {
                    showValidationError("last_name", "Given name \"" + LastName + "\" length is not acceptable!");
                    disproveCorectness("last_name");
                    validation = false;
                } else {
                    hideValidationErorr("last_name");
                    aproveCorectness("last_name");
                }

                if (Email.trim() == "" || !validateEmail(Email)) {
                    showValidationError("email", "Given email \"" + Email + "\" is not correct!");
                    disproveCorectness("email");
                    validation = false;
                } else {
                    hideValidationErorr("email");
                    aproveCorectness("email");
                }

                if (Gender === null) {
                    showValidationError("gender", "Select gender!");
                    disproveCorectness("gender");
                    validation = false;
                } else {
                    hideValidationErorr("gender");
                    aproveCorectness("gender");
                }

                if (Password.trim() == "" || !validatePassword(Password)) {
                    showValidationError("password", "Given password is not correct!");
                    disproveCorectness("password");
                    validation = false;
                } else {
                    hideValidationErorr("password");
                    aproveCorectness("password");
                }

                if (Password !== Password2 || !validatePassword(Password2)) {
                    showValidationError("password2", "Given passwords are not the same!");
                    disproveCorectness("password2");
                    validation = false;
                } else {
                    hideValidationErorr("password2");
                    aproveCorectness("password2");
                }

                if (validation && confirm('Are you ready to register your profile?')) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
{/block}
