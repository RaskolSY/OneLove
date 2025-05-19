<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center py-4">
                    <h4><i class="fas fa-sign-in-alt me-2"></i>Вход в аккаунт</h4>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="login">

                        <!-- Логин -->
                        <div class="mb-3 input-group-lg">
                            <label class="form-label">Логин</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                <input type="text" name="login" class="form-control form-control-lg" placeholder="Введите логин" required>
                            </div>
                        </div>

                        <!-- Пароль -->
                        <div class="mb-4 input-group-lg">
                            <label class="form-label">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="pass" class="form-control form-control-lg" placeholder="••••••••" required>
                            </div>
                        </div>

                        <!-- Кнопка входа -->
                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Войти
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Нет аккаунта? <a href="index.php?page=reg" class="text-success">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </div>
</div>