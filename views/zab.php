<p></p>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Подтверждение покупки</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post">
                    <input type="hidden" name="id_an" value="<?=$_REQUEST['id_an']?>">
                <input type="hidden" name="action" value="zab">
        <div class="form-group">
        <label for="nam" style="color: black;">Название:</label>
    <input type="text" class="form-control" name="card_name" id="card_name" placeholder="Введите название карточки" value="<?php echo $res['nazvanie']; ?>">
        </div>
        <div class="form-group">
        <label for="nam" style="color: black;">Марка:</label>
    <input type="text" class="form-control" name="card_name" id="card_name" placeholder="Введите название карточки" value="<?php echo $res['marka']; ?>">
        </div>
        <div class="form-group">
        <label for="nam" style="color: black;">Модель:</label>
    <input type="text" class="form-control" name="card_name" id="card_name" placeholder="Введите название карточки" value="<?php echo $res['model']; ?>">
        </div>
        <div class="form-group">
        <label for="cena" style="color: black;">Цена:</label>
    <input type="text" class="form-control" name="card_price" id="card_price" placeholder="Введите цену" value="<?php echo $res['price']; ?>">
        </div>
    </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Закрыть</button>
        <div class="modal-body">
                    <?php 
            if(isset($_SESSION['id'])) { 
            } else { 
                echo "<h4 style='color: red;'>Чтобы отправить заявку - авторизируйтесь!</h4>"; 
            } 
                ?> 
        <div style="text-align:center">
    <button type="submit" class="btn btn-outline-dark mt-3" style="color: white !important;" data-target="#eventModal<?php echo $row['id']; ?>"<?php if (!isset($_SESSION['id'])) echo 'hidden'; ?>>Отправить</button> 
    </div>
                </form>
            </div>
        </div>
    </div>
</div>
