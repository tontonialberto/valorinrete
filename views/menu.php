<div class="menu">
    <ul>
        <li>
            <a style="cursor: pointer">
                <i class="fa fa-user roundGreyIcon"></i>
                <?php echo $user['email']; ?>
            </a>
        </li>
        
        <?php if($user['lv'] === 'col'): ?>
        <li>
            <a href="<?php echo site_url('col/subscriptions'); ?>">
                <i class="fa fa-table roundGreyIcon"></i>
                Estrazione Iscritti
            </a>
        </li>
        <?php endif; ?>
        
        <?php if($user['lv'] === 'istituto'): ?>
        <li>
            <a href="<?php echo site_url('istituto/add_subscriptions'); ?>">
                <i class="glyphicon glyphicon-plus roundGreyIcon"></i>
                Aggiungi Classi/Studenti
            </a>
        </li>
        <li>
            <a href="<?php echo site_url('istituto/profile_overview'); ?>">
                <i class="glyphicon glyphicon-list-alt roundGreyIcon"></i>
                Riepilogo Dati
            </a>
        </li>
        <?php endif; ?>

        <li>
            <a href="<?php echo site_url('col/logout'); ?>">
                <i class="fa fa-sign-out roundGreyIcon"></i> 
                Logout
            </a>
        </li>
    </ul>
</div>