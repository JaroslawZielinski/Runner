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
        <h1>Login form</h1>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form id="login" action="{$backendPath}" class="form-horizontal" method="POST" role="form" novalidate autocomplete="off">
                <input name="csrf-token" type="hidden" value="{$csrfToken}">

                <div class="form-group" style="position: static;">
                    <label for="email">Login</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Enter login" autocomplete="off">
                    <p class="help-block">Enter login...</p>
                </div>

                <div class="form-group" style="position: static;">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" autocomplete="off">
                    <p class="help-block">Enter password.</p>
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
            jQuery('form#login').on('submit', function() {
                var validation = true;

                var Email = jQuery('input#email').val();
                var Password = jQuery('input#password').val();

                if ('' === Email.trim() || !SimpleFormUtils.validateEmail(Email)) {
                    SimpleFormUtils.showValidationError('email', 'Given email "' + Email + '" is not correct!');
                    SimpleFormUtils.disproveCorectness('email');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('email');
                    SimpleFormUtils.aproveCorectness('email');
                }

                if ('' === Password.trim() || !SimpleFormUtils.validatePassword(Password)) {
                    SimpleFormUtils.showValidationError('password', 'Given password is not correct!');
                    SimpleFormUtils.disproveCorectness('password');
                    validation = false;
                } else {
                    SimpleFormUtils.hideValidationErorr('password');
                    SimpleFormUtils.aproveCorectness('password');
                }

                return validation;
            });
        });
    </script>
{/block}
