<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="col-lg-12">
        <form id="form-bx24" method="post">
            <div class="form-group row">
                <label for="name" class="col-lg-1 col-form-label">Имя</label>
                <div class="col-lg-11">
                    <input class="form-control" type="text" value="<?= $values['name'] ?>" id="name" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-lg-1 col-form-label">Телефон<span class="require">*</span></label>
                <div class="col-lg-11">
                    <input class="form-control" type="tel" value="<?= $values['phone'] ?>" id="phone" name="phone">
                </div>
            </div>
            <div class="form-group row">
                <label for="position" class="col-lg-1 col-form-label">Должность</label>
                <div class="col-lg-11">
                    <input class="form-control" type="text" value="<?= $values['position'] ?>" id="position" name="position">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-lg-1 col-form-label">Email<span class="require">*</span></label>
                <div class="col-lg-11">
                    <input class="form-control" type="text" value="<?= $values['email'] ?>" id="email" name="email">
                </div>
            </div>

            <div class="form-group row">
                <label for="products" class="col-lg-1 col-form-label">Товары</label>
                <div class="col-lg-11">
                    <select class="form-control" id="products-multiselect" multiple name="products[]">
                        <option value="Банан" <?php if (in_array('Банан', $values['products'])) : echo 'selected'; endif; ?>>Банан</option>
                        <option value="Арбуз" <?php if (in_array('Арбуз', $values['products'])) : echo 'selected'; endif; ?>>Арбуз</option>
                        <option value="Мандарин" <?php if (in_array('Мандарин', $values['products'])) : echo 'selected'; endif; ?>>Мандарин</option>
                        <option value="Яблоко" <?php if (in_array('Яблоко', $values['products'])) : echo 'selected'; endif; ?>>Яблоко</option>
                        <option value="Персик" <?php if (in_array('Персик', $values['products'])) : echo 'selected'; endif; ?>>Персик</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary submit-bx24" name="submit-bx24">
                        Отправить
                    </button>
                </div>
            </div>
            <div class="alert-wrapper">
                <?php if (isset($errors) and !empty($errors)) : ?>
                    <?php foreach ($errors as $error) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error['message'] ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (FlashMessage::hasFlash('success-send')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= FlashMessage::getFlash('success-send') ?>
                    </div>
                <?php endif; ?>
            </div>
        </form>

    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>