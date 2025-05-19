<h3 style="color: white; text-align: center; ">Ваши заказы</h3>
<?php
$r=$db->dbs->prepare("SELECT T.nazvanie, T.url, T.marka, T.model, T.price, O.status, O.id FROM `tovar` T, `orders` O WHERE O.id_tovar=T.id AND O.id_users=:i;");
$r->execute([':i'=>$_SESSION['id']]);
$count = 0;
  if ($r->rowCount() != 0) {
      echo '<div class="row row-cols-1 row-cols-md-2 g-4">';
      foreach ($r as $res) {
  ?>
          <div class="col-md-3" style="margin-bottom: 10px;"> <!-- Set the column size to auto and add margin for spacing -->
          <div class="card bg-dark text-white" style="height: 100%;">
              <img style="height: 40%;" src="<?= $res['url'] ?>" class="card-img-top" alt="Image">
              <div class="card-body d-flex flex-column justify-content-between ">
              <h5 class="card-title text-center" style="font-weight: bold; font-size: 18px;"> <?= $res['nazvanie'] ?></h5>
                      <p class="card-text">Марка: <?= $res['marka'] ?></p>
                      <p class="card-text">Модель: <?= $res['model'] ?></p>
                      <p class="card-text">Цена: <?= $res['price'] ?>₽</p>
                      <h6 class="card-text text-success text-center">Статус: <?= $res['status'] ?></h6>
                  <div class="mt-auto text-center"> <!-- Center the button -->
              </div>
          </div>
      </div>
      </div>
  <?php
          $count++;
      }
      echo '</div>'; // Close the row
  }
  ?>
</div>