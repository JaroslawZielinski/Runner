{extends file="{$homepage}"}

{block name=head}
    <script src="/js/form.utils.js" type="text/javascript"></script>
{/block}

{block name=message-box}
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            {if isset($message)}
                {include file="`$templateDir`message.tpl" alertType=$message.type|default:'info' message=$message.content|default:'Empty message'}
            {/if}
        </div>
        <div class="col-md-2"></div>
    </div>
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
            jQuery('#register').on('submit', function(event) {
                var validation = true;

                var FirstName = jQuery('input#first_name').val();
                var LastName = jQuery('input#last_name').val();
                var Email = jQuery('input#email').val();
                var Gender = jQuery('select#gender').val();
                var Password = jQuery('input#password').val();
                var Password2 = jQuery('input#password2').val();

                if ('' === FirstName.trim()) {
                    SimpleFormUtils.showValidationError('first_name', 'Given name "' + FirstName + '" length is not acceptable!');
                    SimpleFormUtils.disproveCorectness('first_name');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('first_name');
                    SimpleFormUtils.aproveCorectness('first_name');
                }

                if ('' === LastName.trim()) {
                    SimpleFormUtils.showValidationError('last_name', 'Given name "' + LastName + '" length is not acceptable!');
                    SimpleFormUtils.disproveCorectness('last_name');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('last_name');
                    SimpleFormUtils.aproveCorectness('last_name');
                }

                if ('' === Email.trim() || !SimpleFormUtils.validateEmail(Email)) {
                    SimpleFormUtils.showValidationError('email', 'Given email "' + Email + '" is not correct!');
                    SimpleFormUtils.disproveCorectness('email');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('email');
                    SimpleFormUtils.aproveCorectness('email');
                }

                if ('' === Gender || null === Gender) {
                    SimpleFormUtils.showValidationError('gender', 'Select gender!');
                    SimpleFormUtils.disproveCorectness('gender');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('gender');
                    SimpleFormUtils.aproveCorectness('gender');
                }

                if ('' === Password.trim() || !SimpleFormUtils.validatePassword(Password)) {
                    SimpleFormUtils.showValidationError('password', 'Given password is not correct!');
                    SimpleFormUtils.disproveCorectness('password');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('password');
                    SimpleFormUtils.aproveCorectness('password');
                }

                if (Password !== Password2 || !SimpleFormUtils.validatePassword(Password2)) {
                    SimpleFormUtils.showValidationError('password2', 'Given passwords are not the same!');
                    SimpleFormUtils.disproveCorectness('password2');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('password2');
                    SimpleFormUtils.aproveCorectness('password2');
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
