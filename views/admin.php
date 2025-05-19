<html lang="ru">
<div style="color: white;"class="row-12 h3 text-center text-white">Админ панель</div>
<ul class="nav justify-content-center ">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php?page=<?= $_REQUEST['page'] ?>&items=categ"
            style="color: white;">Работа с каталогом товаров</a>
    </li>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="index.php?page=<?= $_REQUEST['page'] ?>&items=order" style="color: white;">Работа с
            заказами</a>
    </li>
</ul>
<?php
if (isset ($_REQUEST['items'])) {
    if ($_REQUEST['items'] == 'categ') {
        $r = $db->dbs->prepare("SELECT * FROM tovar;");
        $r->execute();
        if ($r->rowCount() != 0) {
            ?>
            <table class="table caption-top table-dark">
                <caption style="color: white;">Список товаров</caption>
                <thead class="bg-primary-subtle">
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col" class="w-25">Фото</th>
                        <th scope="col" class="w-auto">Название</th>
                        <th scope="col" class="w-auto">Марка</th>
                        <th scope="col" class="w-auto">Модель</th>
                        <th scope="col" class="w-auto">Цена</th>
                        <th scope="col" class="w-auto">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $i = 1;
                    foreach ($r as $res) {
                        print "<tr><th scope=\"row\">" . $i . "</th><td><img src='" . $res['url'] .
                            "' class='rounded float-start img-thumbnail' style='max-height: 150px; max-width: 150px'>
                </td><td>" . $res['nazvanie'] . "</td><td>" . $res['marka'] . "</td><td>" . $res['model'] ."</td><td>" . $res['price'] .
                            "</td><td><a href='index.php?page=" . $_REQUEST['page'] . "&items=" . $_REQUEST['items'] .
                            "&edit=categ&id=" . $res['id'] . "' class='btn btn-outline-success'>Изменить</a>&nbsp;&nbsp;&nbsp;
                <div class='vr'></div>&nbsp;&nbsp;&nbsp;<a href='index.php?page=" . $_REQUEST['page'] . "&items="
                            . $_REQUEST['items'] . "&action=delCat&id=" . $res['id'] . "' class='btn btn-outline-danger'>Удалить</a>
                </td></tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else
            print "<div class=\"row-12 h5 text-center\">Нет категорий</div>";
        if (!isset ($_REQUEST['edit'])) {
            ?>
            <div style="color: white;" class="row-12 h5 text-center">Добавление товара</div>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="page" value="<?= $_REQUEST['page'] ?>">
                <input type="hidden" name="items" value="<?= $_REQUEST['items'] ?>">
                <input type="hidden" name="id" value="<?= $_REQUEST['id'] ?>">
                <input type="hidden" name="action" value="addCateg">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-dark text-light" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                            viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path
                                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                    </span>
                    <div class="form-floating">
                        <input  type="text" name="nazvanie" class="form-control bg-dark text-light"
                            placeholder="Название товара" aria-label="Название категории" aria-describedby="basic-addon1">
                        <label style="color: white;">Название товара</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-dark text-light" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                            viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path
                                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                    </span>
                    <div class="form-floating">
                        <input type="text" name="marka" class="form-control bg-dark text-light" placeholder="Марка" aria-label="Название категории"
                            aria-describedby="basic-addon1" >
                        <label style="color: white;">Марка</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-dark text-light" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                            viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path
                                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                    </span>
                    <div class="form-floating">
                        <input type="text" name="model" class="form-control bg-dark text-light" placeholder="Модель" aria-label="Название категории"
                            aria-describedby="basic-addon1" >
                        <label style="color: white;">Модель</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-dark text-light" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                            viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path
                                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                    </span>
                    <div class="form-floating">
                        <input type="text" name="price" class="form-control bg-dark text-light" placeholder="Цена" aria-label="Название категории"
                            aria-describedby="basic-addon1" >
                        <label style="color: white;">Цена</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-dark text-light" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                            viewBox="0 0 16 16">
                            <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                            <path
                                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                        </svg>
                    </span>
                    <input type="file" name="url" class="form-control bg-dark text-light" id="inputGroupFile04" required
                        aria-describedby="inputGroupFileAddon04" aria-label="Загрузка">
                    <button class="btn btn-outline-secondary text-light" type="submit">Добавить</button>
                </div>
            </form>
            <?php
        }
    }
    if ($_REQUEST['items'] == 'prod') {

    }
    if ($_REQUEST['items'] == 'user') {

    }
    if ($_REQUEST['items'] == 'order') {

    }
    if (isset ($_REQUEST['edit'])) {
        if ($_REQUEST['edit'] == 'categ') {
            $r = $db->dbs->prepare("SELECT * FROM tovar WHERE id=:i");
            $r->execute([':i' => $_REQUEST['id']]);
            foreach ($r as $res) {
                ?>
                <div style="color: white;" class="row-12 h5 text-center">Изменение товара</div>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="page" value="<?= $_REQUEST['page'] ?>">
                    <input type="hidden" name="items" value="<?= $_REQUEST['items'] ?>">
                    <input type="hidden" name="id" value="<?= $res['id'] ?>">
                    <input type="hidden" name="action" value="editCateg">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                                viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                            </svg>
                        </span>
                        <div class="form-floating">
                            <input type="text" name="nazvanie" class="form-control bg-dark text-light" placeholder="Название товара" aria-label="Название"
                                aria-describedby="basic-addon1" value="<?= $res['nazvanie'] ?>">
                            <label style="color: white;">Название товара</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                                viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                            </svg>
                        </span>
                        <div class="form-floating">
                            <input type="text" name="marka" class="form-control bg-dark text-light" placeholder="Марка" aria-label="Название категории"
                                aria-describedby="basic-addon1" value="<?= $res['marka'] ?>">
                            <label style="color: white;">Марка</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                                viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                            </svg>
                        </span>
                        <div class="form-floating">
                            <input type="text" name="model" class="form-control bg-dark text-light" placeholder="Модель" aria-label="Название категории"
                                aria-describedby="basic-addon1" value="<?= $res['model'] ?>">
                            <label style="color: white;">Модель</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                                viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                            </svg>
                        </span>
                        <div class="form-floating">
                            <input type="text" name="price" class="form-control bg-dark text-light" placeholder="Цена" aria-label="Название"
                                aria-describedby="basic-addon1" value="<?= $res['price'] ?>">
                            <label style="color: white;">Цена</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-dark text-light" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag"
                                viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                            </svg>
                        </span>
                        <input require type="file" name="url" class="form-control bg-dark text-light" id="inputGroupFile04" required
                            aria-describedby="inputGroupFileAddon04" aria-label="Загрузка">
                        <button class="btn btn-outline-dark text-light" type="submit">Изменить</button>
                    </div>
                </form>
                <?php
            }
        }
    }
}else 
?>
<?php
if (isset($_REQUEST['items'])){
    if ($_REQUEST['items']=='order'){
    $r=$db->dbs->prepare("SELECT * FROM orders;");
    $r->execute();
    if ($r->rowCount()!=0){
        ?>
        <table class="table caption-top table-dark ">
            <caption style="color: white;">Список заказов</caption>
            <thead class="bg-primary-subtle">
            <tr>
                <th scope="col">№</th>
                <th scope="col" class="w-auto">Номер пользователя</th>
                <th scope="col" class="w-auto">Номер товара</th>
                <th scope="col" class="w-auto">Дата заказа</th>
                <th scope="col" class="w-auto">Статус</th>
                <th scope="col" class="w-auto">Действие</th>
            </tr>
            </thead>
            <tbody>
            <?
            $i=1;
            foreach ($r as $res){
                print  "<tr><th scope=\"row\">".$i."</th><td>".$res['id_users']."</td><td>". 
                $res['id_tovar']."</td><td>".$res['date']."</td><td>".$res['status']."</td><td><a href='index.php?page=".
                $_REQUEST['page']."&items=".$_REQUEST['items']."&edit=order&id=".
                $res['id']."' class='btn btn-outline-success'>Изменить</a>&nbsp;&nbsp;&nbsp;<div class='vr'></div>&nbsp;&nbsp;&nbsp;<a href='index.php?page=".
                $_REQUEST['page']."&items=".$_REQUEST['items']."&action=delOrder&id=".
                $res['id']."' class='btn btn-outline-danger'>Удалить</a></td></tr>";
                $i++;
            }   
            ?>
            </tbody>
        </table>
        <?php
    }else print "<div class=\"row-12 h5 text-center\">Нет категорий</div>";
    if (!isset($_REQUEST['edit'])) {
    }
    }
    if ($_REQUEST['items']=='prod'){

    }
    if ($_REQUEST['items']=='user'){

    }
    if ($_REQUEST['items']=='order'){

    }
    if (isset($_REQUEST['edit'])){
        if ($_REQUEST['edit']=='order'){
            $r=$db->dbs->prepare("SELECT * FROM orders WHERE id=:i");
            $r->execute([':i'=>$_REQUEST['id']]);
            foreach ($r as $res){
            ?>
             <div style="color: white;" class="row-12 h5 text-center">Изменение заказа</div>
            <form method="post">
                <input type="hidden" name="action" value="editZav">
                <input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
                <div class="form-floating">
                    <select name="status" class="form-select bg-dark text-light" aria-label="">
                        <option value="Ждет подтверждения оплаты" <?php if($res['status'] == 'Ждет подтверждения оплаты') echo 'selected'; ?>>Ждет подтверждения оплаты</option>
                        <option value="Оплачено" <?php if($res['status'] == 'Оплачено') echo 'selected'; ?>>Оплачено</option>
                        <option value="Оплата не прошла" <?php if($res['status'] == 'Оплата не прошла') echo 'selected'; ?>>Оплата не прошла</option>
                    </select>
                    <label style="color: white;">Статус заказа</label>
                </div>
                <div class="input-group mb-3">
                    <button class="btn btn-dark" type="submit">Изменить</button>
                </div>
            </form>
            <?php
            }
        }
    }
}
