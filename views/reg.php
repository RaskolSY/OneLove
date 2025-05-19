<p></p>
<div class="row justify-content-center">
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="width: 100%;">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Регистрация</h3>

                <form method="post">
                    <input type="hidden" name="action" value="reg">

                    <!-- ФИО -->
                    <div class="mb-4 input-group-lg">
                        <label class="form-label visually-hidden">ФИО</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="fio" class="form-control form-control-lg" placeholder="Фамилия Имя Отчество" required>
                        </div>
                    </div>

                    <!-- Логин -->
                    <div class="mb-4 input-group-lg">
                        <label class="form-label visually-hidden">Логин</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-at"></i>
                            </span>
                            <input type="text" name="login" class="form-control form-control-lg" placeholder="Логин" required>
                        </div>
                    </div>

                    <!-- Пароль -->
                    <div class="mb-4 input-group-lg">
                        <label class="form-label visually-hidden">Пароль</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="pass" class="form-control form-control-lg" placeholder="Пароль" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4 input-group-lg">
                        <label class="form-label visually-hidden">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="mail" class="form-control form-control-lg" placeholder="example@example.com" required>
                        </div>
                    </div>

                    <!-- Кнопка регистрации -->
                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-registered me-2"></i>Зарегистрироваться
                        </button>
                    </div>

                    <!-- Ссылка на вход -->
                    <div class="text-center mt-3">
                        Уже есть аккаунт? <a href="index.php?page=auth" class="text-primary fw-bold">Войдите</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>