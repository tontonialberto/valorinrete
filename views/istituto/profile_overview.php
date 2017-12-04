<div class="corpo">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3>Riepilogo Dati</h4>
        </div>
        <div class="panel-body">
            <h2><?php echo $title; ?></h2>
            <h4>Riepilogo Dati Istituto</h4>
            Codice Meccanografico:
            <?php echo $istituto['cod_meccanografico']; ?>
            <br />
            Nome Istituto:
            <?php echo $istituto['nome_istituto']; ?>
            <br />
            Email Istituto:
            <?php echo $istituto['email_istituto']; ?>
            <br />
            Regione: 
            <?php echo $istituto['regione']; ?>
            <br />
            Provincia:
            <?php echo $istituto['provincia']; ?>
            <br />
            Comune:
            <?php echo $istituto['comune']; ?>
            <br />
            Indirizzo
            <?php echo $istituto['indirizzo']; ?>
            <br />
            Nome e cognome referente:
            <?php echo $istituto['nome_referente'].' '.$istituto['cognome_referente']; ?>
            <br />
            Email Referente:
            <?php echo $istituto['email_referente']; ?>
            <br />
            <br />

            <h4>Riepilogo Candidature</h4>
            <?php foreach($candidature as $candidatura): ?>
                Progetto:
                <?php echo $candidatura['progetto']; ?>
                <br />
                Nome e cognome referente:
                <?php echo $candidatura['nome_referente'].' '.$candidatura['cognome_referente']; ?>
                <br />
                Telefono referente:
                <?php echo $candidatura['telefono_referente']; ?>
                <br />
            <?php endforeach; ?>
        </div>
    </div>
</div>