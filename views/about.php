<div class="container mt-2">
  <?php
  $r = $db->dbs->prepare("SELECT * FROM tovar");
  $r->execute();
  $count = 0;
  if ($r->rowCount() != 0) {
      echo '<div class="row row-cols-1 row-cols-md-2 g-4">';
      foreach ($r as $res) {
  ?>
          <div class="col-md-3" style="margin-bottom: 10px;"> <!-- Set the column size to auto and add margin for spacing -->
              <div class="card bg-dark" style="height: 100%;">
                  <img style="height: 40%;" src="<?= $res['url'] ?>" class="card-img-top" alt="Image">
                  <div class="card-body d-flex flex-column justify-content-between text-light">
          <h5 class="card-title text-center" style="font-weight: bold; font-size: 20px;"><?= $res['nazvanie'] ?></h5>
          <p class="card-text">Марка: <?= $res['marka'] ?></p>
                      <p class="card-text">Модель: <?= $res['model'] ?></p>
                      <p class="card-text">Цена: <?= $res['price'] ?>₽</p>
                      <div class="mt-auto text-center"> <!-- Center the button -->
                    <button type="submit" class="btn btn-outline-light buy d-block mx-auto" data-toggle="modal" data-target="#eventModal<?php echo $res['id']; ?> ">Купить</button>                      </div>
                  </div>
              </div>
          </div>
          
          <div class="modal fade" id="eventModal<?php echo $res['id']; ?>" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-light" id="exampleModalLabel">Подтверждение оплаты</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">  
            <h5 for="getticket">Название:</h5>
            <input type="text" class="form-control" id="getticket" value="<?= $res['nazvanie'] ?>">
        </div>
        <div class="form-group">  
            <h5 for="getticket">Марка:</h5>
            <input type="text" class="form-control" id="getticket" value="<?= $res['marka'] ?>">
        </div>
        <div class="form-group">  
            <h5 for="getticket">Модель:</h5>
            <input type="text" class="form-control" id="getticket" value="<?= $res['model'] ?>">
        </div>
        <div class="form-group">
            <h5 for="priceticket">Цена:</h5>
            <input type="number" class="form-control" id="priceticket" value="<?= $res['price'] ?>">
        </div>
        <form method="post">
        <input type="hidden" name="action" value="submit_application">
        <input type="hidden" name="id_tovar" value="<?php echo $res['id']; ?>">
        <input type="hidden" name="id_users" value="<?php echo $id_users; ?>">
      </div>
      
      <?php
        if(isset($_SESSION['id'])) {
        }else {
            echo "<h6 class='text-dark' style='text-align: center;'>Чтобы купить товар, войдите в систему!</h6>";
            }
        ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger d-block mx-left" data-dismiss="modal">Отказаться</button>
        <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#eventModal<?php echo $res['id']; ?>"<?php if (!isset($_SESSION['id'])) echo 'hidden'; ?>>Оплатить</button>
      </div>
    </div>
  </div>
</div>      
          </form>  
  <?php
          $count++;
      }
      echo '</div>'; // Close the row
  }
  ?>
</div>


