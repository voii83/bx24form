<?php

class Form
{
    public function actionForm()
    {
        $model = new FormModel();

        if (isset($_POST['submit-bx24'])) {
            $model->loadParams($_POST);

            if ($model->validate() && $model->send()) {
                FlashMessage::setFlash('success-send', 'Ваша заявка принята, с вами свяжутся в течение 2-х часов');
                header("Location: " . $_SERVER["REQUEST_URI"]);
                exit;
            } else {
                $errors = $model->getValidateErrors();
            }
        }

        $values = $model->getFieldsValue();

        require_once(ROOT.'/views/form/index.php');
    }
}