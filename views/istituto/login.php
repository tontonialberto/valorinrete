<div class="container">
    <span>
        <h4>
            <?php if(isset($message)) echo $message; ?>
            <h4><?php if(isset($error)) echo $error; ?></h4>
        </h4>
    </span>
    <form method="post" action="<?php echo site_url('istituto/login_process'); ?>">
        <div style="margin-top: 20px" class="panel panel-default">
            <div class="panel-heading">
                <h4><?php echo $title; ?></h4>
            </div>
            <div class="panel-body">
                <label class="form-label">E-mail Referente:</label>
                <input type="text" class="form-control form-field" name="email" />

                <label class="form-label">Password:</label>
                <input type="password" class="form-control form-field" name="password" />

                <button type="submit" class="btn btn-success btn-block btn-fat">Accedi</button>
                
                <a href="<?php echo site_url('istituto/ask_for_new_password'); ?>">
                    Password dimenticata?
                </a>
            </div>
        </div>
    </form>
</div>