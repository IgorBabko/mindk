<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('login'); ?>" method="post" id="login-form" novalidate>
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Authentication</h3>
        </div>
        <div class="panel-body">
            <?php $hasError = Util::errorBox($this->fail); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="username">Username:</label>
                <input autocomplete="off" type="text" class="form-control" name="_username" id="username"
                       placeholder="Username"
                       value="<?= isset($_POST['_username']) ? $_POST['_username'] : ''; ?>">
            </div>
            <div class="form-group <?= $hasError; ?>">
                <label for="password">Password:</label>
                <input autocomplete="off" type="password" class="form-control" name="_password" id="password"
                       placeholder="Password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" id="remember" value="yes">Remember me
                </label>
            </div>
            <a class='btn btn-default' role='button' href='<?= $this->router->generateRoute('home'); ?>'>Cancel</a>
            <button type="submit" class="btn btn-success">Log in</button>
        </div>
    </div>
</form>