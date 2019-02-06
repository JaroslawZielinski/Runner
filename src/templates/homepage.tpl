<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Runner">
        <meta name="author" content="Jarosław Zieliński">
        <link rel="icon" href="/images/favicon.ico">

        <title>Runner</title>

        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        {*<link href="/css/bootstrap-theme.min.css" rel="stylesheet">*}
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/popper.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>

        <!-- Custom styles for Task1 -->
        <link href="/css/runner.css" rel="stylesheet">

        {block name=head}{/block}
    </head>

    <body>

        {block name=navigation}
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                <a class="navbar-brand" href="/">Runner</a>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">
                        {foreach $menus as $menu}
                            {if $menu.visible == 'true'}
                                <li class="nav-item {if $path == $menu.route}active{/if}">
                                    <a class="nav-link" href="{$menu.route}">{$menu@key}</a>
                                </li>
                            {/if}
                        {/foreach}
                    </ul>
                    <div class="my-2 my-lg-0 navbar-dark navbar-brand">
                        {if isset($userLogged)}
                            {$userLogged.login}
                        {/if}
                    </div>
                </div>
            </nav>
        {/block}

        <main role="main" class="container">
            {block name=message-box}
                {if isset($message)}
                    {include file="`$templateDir`message.tpl" alertType=$message.type|default:'info' message=$message.content|default:'Empty message'}
                {/if}
            {/block}

            {block name=content}
                <div class="runner">
                    <h1>Runner</h1>
                </div>
                <div>
                    <p class="lead">Useful commands:</p>
                    <p class="ssh-style">cd Runner</p>
                    <p class="ssh-style">composer install</p>
                    <p class="ssh-style">run/dockerized destroy</p>
                    <p class="ssh-style">run/dockerized build</p>
                    <p class="ssh-style">run/dockerized init</p>
                    <p class="ssh-style">docker exec -it runner_php_1 ash -c "source .env && vendor/bin/phinx migrate -e development"</p>
                    <p class="ssh-style">run/dockerized serverOnly</p>
                </div>
            {/block}

            {block name=footer}
                {*Template from https://getbootstrap.com/docs/4.1/examples/starter-template/ *}
                <footer class="pt-2 lgrey">
                    <div class="text-center py-2">Github page:
                        <a href="https://github.com/JaroslawZielinski" target="_blank"> JaroslawZielinski</a>
                    </div>
                    <div class="text-center py-2">LinkedIn page:
                        <a href="https://linkedin.com/in/jzielinski82" target="_blank"> JaroslawZielinski</a>
                    </div>
                </footer>
            {/block}
        </main>
    </body>
</html>
