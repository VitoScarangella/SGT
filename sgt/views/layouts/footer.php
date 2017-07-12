    <div class="container">
        <p class="pull-left">&copy; ZZigto <?= date('Y') ?></p>

        <p class="pull-right">
          <?
          if (isset($session["canChangeUser"]))
          {
          ?>
          <a href="<?=Yii::$app->request->baseUrl?>/efxtool"><span class="glyphicon glyphicon-user"></span>
            <?=$session["masterUser"]["cognome"]." ".$session["masterUser"]["nome"]?>
          </a>
          <?
          }
          ?>
        </p>
    </div>
    <div class="container">
        <p class="pull-left"><a href="https://.../SS">Download Area</a></p>
    </div>
