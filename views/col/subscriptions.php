<div class="corpo">
    <h2><?php echo $title; ?></h2>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
          <h3><?php echo $user['regione']; ?></h3>
        </div>

        <form action="<?php echo site_url('col/subscriptions'); ?>">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="col-md-8 col-lg-8">
              <select class="form-control" name="filtra_iscritti_provincia">
                <option value="">Filtra per Provincia</option>
                <?php foreach($province as $provincia): ?>
                <option value="<?php echo $provincia['nome']; ?>"><?php echo $provincia['nome']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary">Filtra</button>
            </div>
          </div>
        </form>
    </div>
    <div class="row">
      <table class="table">
          <tr>
              <th>Progetto</th>
              <th>N° Iscritti</th>
          </tr>
          <?php foreach($subscriptions as $sub): ?>
          <tr>
              <td><?php echo $sub['nome_progetto']; ?></td>
              <td><?php echo $sub['n_studenti']; ?></td>
          </tr>
          <?php endforeach; ?>
      </table>
    </div>
</div>
