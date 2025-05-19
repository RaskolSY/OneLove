<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php?page=auth");
    exit();
}

// Получаем биты пользователя
$stmt = $db->prepare("SELECT * FROM bit WHERE id_users = ?");
$stmt->execute([$_SESSION['id']]);
$bits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h3 class="text-center mb-4">Мои биты</h3>

    <!-- Кнопка добавить бит -->
    <div class="text-end mb-3">
        <a href="index.php?page=add_bit" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Добавить бит
        </a>
    </div>

    <!-- Сетка битов -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ($bits): ?>
            <?php foreach ($bits as $bit): ?>
                <?php
                // Получаем все лицензии для этого бита
                $stmtLicense = $db->prepare("SELECT * FROM license WHERE id_bit = ?");
                $stmtLicense->execute([$bit['id']]);
                $licenses = $stmtLicense->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-white rounded-4 overflow-hidden">
                        <!-- Обложка -->
                        <img src="<?= htmlspecialchars($bit['obl']) ?>" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;" 
                             alt="<?= htmlspecialchars($bit['name']) ?>">

                        <div class="card-body d-flex flex-column">
                            <!-- Название -->
                            <h5 class="card-title text-center"><?= htmlspecialchars($bit['name']) ?></h5>

                            <!-- Жанр -->
                            <p class="card-text"><strong>Жанр:</strong> <?= htmlspecialchars($bit['janr'] ?? 'Не указан') ?></p>

                            <!-- BPM -->
                            <p class="card-text"><strong>BPM:</strong> <?= $bit['bpm'] ?? '---' ?></p>

                            <!-- Цены из лицензий -->
                            <p class="card-text mb-2">
                                <strong>Цена:</strong><br>
                                <?php if (!empty($licenses)): ?>
                                    <?php foreach ($licenses as $license): ?>
                                        <span class="text-primary fs-5">$<?= $license['price'] ?></span> — <?= htmlspecialchars($license['name']) ?><br>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Лицензия не добавлена</span>
                                <?php endif; ?>
                            </p>

                            <!-- Аудиоплеер -->
                            <div class="mt-3">
                                <audio controls class="w-100" style="height: 40px;">
                                    <source src="<?= htmlspecialchars($bit['mp3']) ?>" type="audio/mpeg">
                                    <?php if (!empty($bit['wav'])): ?>
                                        <source src="<?= htmlspecialchars($bit['wav']) ?>" type="audio/wav">
                                    <?php endif; ?>
                                    Ваш браузер не поддерживает аудио.
                                </audio>
                            </div>

                            <!-- Статус -->
                            <div class="mt-3">
                                <strong>Статус:</strong>
                                <?php if ($bit['status'] == 1): ?>
                                    <span class="badge bg-success">Опубликован</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Скрыт</span>
                                    <small class="text-muted d-block">Ожидает одобрения</small>
                                <?php endif; ?>
                            </div>

                            <!-- Доступно только админу -->
                            <?php if ($_SESSION['status'] == 100): ?>
                                <form method="post" class="mt-auto">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?= $bit['id'] ?>">
                                    
                                    <div class="mt-3 d-flex gap-2 align-items-center">
                                        <select name="status" class="form-select form-select-sm" required>
                                            <option value="">Выберите статус</option>
                                            <option value="1">Опубликовать</option>
                                            <option value="0">Скрыть</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <!-- Кнопка "Посмотреть лицензии" -->
                            <div class="mt-3 text-center">
                                <button class="btn btn-outline-dark btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#licenseModal<?= $bit['id'] ?>">
                                    <i class="fas fa-file-contract me-2"></i>Посмотреть лицензии
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Модальное окно с лицензиями -->
                <div class="modal fade" id="licenseModal<?= $bit['id'] ?>" tabindex="-1" aria-labelledby="licenseModalLabel<?= $bit['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <div class="modal-header bg-success text-white rounded-0">
                                <h5 class="modal-title" id="licenseModalLabel<?= $bit['id'] ?>">Лицензии на бит "<?= htmlspecialchars($bit['name']) ?>"</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <?php if (!empty($licenses)): ?>
                                    <table class="table table-striped table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Название</th>
                                                <th scope="col">Запись музыки</th>
                                                <th scope="col">Коммерческие выступления</th>
                                                <th scope="col">Онлайн прослушиваний</th>
                                                <th scope="col">Проданные копии</th>
                                                <th scope="col">Радио</th>
                                                <th scope="col">Видео</th>
                                                <th scope="col">Цена</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($licenses as $license): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($license['name']) ?></td>
                                                    <td><?= $license['zapisMus'] == 1 ? 'Да' : 'Нет' ?></td>
                                                    <td><?= $license['vistup'] == 1 ? 'Да' : 'Нет' ?></td>
                                                    <td><?= $license['kolPros'] ?></td>
                                                    <td><?= $license['kolProdCop'] ?></td>
                                                    <td><?= $license['kolRadio'] ?></td>
                                                    <td><?= $license['kolVideo'] ?></td>
                                                    <td><strong>$<?= $license['price'] ?></strong></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="text-center text-muted">У этого бита пока нет лицензий</p>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">У вас пока нет добавленных битов</p>
        <?php endif; ?>
    </div>
</div>